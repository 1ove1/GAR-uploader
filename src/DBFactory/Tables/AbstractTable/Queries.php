<?php declare(strict_types=1);

namespace LAB2\DBFactory\Tables\AbstractTable;

trait Queries
{
	// ?string  		$name = null;
	// ?array 			$fields = null;
	// ?array   		$metaInfo = null;
	// ?/PDOStatement   $PDOInsert = null;
	// ?/PDOStatement   $PDODelete = null;
	// 
	/**
	 *  Select method (simple sql query)
	 * @param  string      $fields    fields that needs to select
	 * @param  string|null $condition WHERE condition
	 * @param  array|null  $element   WHERE element for condition
	 * @return array 				  query result
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

		try{
			return $this->PDO->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		} catch (\PDOException $exception)
		{
			echo $exception->getMessage() . ' ' . $exception->getCode();
			return [];
		}
	}

	/**
	 *  insert query
	 * @param  array  $fields_values array with field => value struct 
	 * @return voids
	 */
	public function insert(array $fields_values) : void
	{
		try {
			$this->PDOInsert->execute($fields_values);
		} catch (\PDOException $exception) {
			echo $exception->getMessage() . ' ' . $exception->getCode();
		}
	}
}