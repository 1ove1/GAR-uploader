<?php declare(strict_types=1);

namespace TPO\LAB2\DBFactory\Tables\AbstractTable;

use TableItem;
use TPO\LAB2\DBFactory\DBFacade;

trait AbstractTable
{
	// ?string  $name = null;
	// ?array 	$fields = null;
	// ?/PDO 	$PDO 	= null;

	/**
	 * Class name to class table (CamelCase to snake_case)
	 * @param  string $className Class name
	 * @return void            	 
	 */
	protected function getTableName(string $className) : void
	{
		foreach (str_split(strtolower($className)) as $key => $char) {
			if ($key !== 0 && ctype_upper($className[$key])) {
				$this->name .= '_';
			}
			$this->name .= $char;
		}
	}

	/**
	 *  Select method (simple sql query)
	 * @param  string      $fields    fields that needs to select
	 * @param  string|null $condition WHERE condition
	 * @param  array|null  $element   WHERE element for condition
	 * @return array 				  query result
	 */
	public function select(array|string $fields = '*', ?string $condition = null, ?array $element = null) : array {
		$query = '';

		if (is_array($fields)) {
			$fields = array_reduce($fields, fn($x, $y) => $x .= ',' . $y);
		}

		$query .= 'SELECT ' . $fields . ' FROM ' . $this->name;
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
}