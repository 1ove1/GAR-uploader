<?php declare(strict_types=1);

namespace GAR\Uploader\Models\AbstractTable;


/**
 * TRAIT QUERIES
 *
 * IMPLEMENTS SOME METHODS FROM ABSTRACTTABLE INTERFACE
 */
trait Queries
{

    /**
     *  Select method (simple sql query)
     * @param array|string $fields fields that need to select
     * @param string|null $condition WHERE condition
     * @param array|null $element WHERE element for condition
     * @return array                  query result
     */
	public function select(array|string $fields = '*', ?string $condition = null, ?array $element = null) : array 
	{
		$fields_str = (is_array($fields)) ? 
			implode(',', $fields):
			$fields;
		$query = 'SELECT ' . $fields_str . ' FROM ' . $this->name;

		if (!empty($condition)) {
			$query .= ' WHERE ' . $element[0] . $condition . $element[1];
		}

		return $this->PDO->query($query)->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 *  insert query
	 * @param  array  $fields_values array with field => value struct 
	 * @return void
	 */
	public function insert(array $fields_values) : void
	{
		$fields_values = array_values($fields_values);

		$currLzyInsCount = count($this->lzyInsSaver);
		$currInpValCount = count($fields_values);
		$isValid = ($currLzyInsCount / $currInpValCount) === $this->currLzyInsStep;

		if (empty($this->lzyInsSaver) || $isValid) {
			$this->lzyInsSaver = array_merge($this->lzyInsSaver, $fields_values);
			$this->currLzyInsStep++;
			
			
			if ($this->currLzyInsStep === $this->maxLzyInsStep) {
				$this->save();
				$this->resetLzyIns();
			}

		} else {
			throw new \InvalidArgumentException(sprintf(
				"param 'fields_values' contains %d values but need %d:\nfields_values => %s",
				$currInpValCount,
				$currLzyInsCount,
				implode(', ', $fields_values),
			));
		}
	}

	public function save() : void 
	{
		if (empty($this->lzyInsSaver)) {
			return;
		}

		if ($this->currLzyInsStep !== $this->maxLzyInsStep) {
			$this->prepareInsertPDOStatement($this->currLzyInsStep);
			$this->PDOInsert->execute($this->lzyInsSaver);
			$this->prepareInsertPDOStatement($this->maxLzyInsStep);
		} else {
			$this->PDOInsert->execute($this->lzyInsSaver);
		}
	}

	private function resetLzyIns() : void {
		$this->currLzyInsStep = 0;
		$this->lzyInsSaver = [];
	}
}