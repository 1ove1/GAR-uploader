<?php declare(strict_types=1);

namespace LAB2\DBFactory\Tables\AbstractTable;

trait AbstractTable
{
	// ?string  		$name = null;
	// ?array 			$fields = null;
	// ?array   		$metaInfo = null;
	// ?/PDOStatement   $PDOInsert = null;
	// ?/PDOStatement   $PDODelete = null;
	// 
	/**
	 * Class name to class table (CamelCase to snake_case)
	 * @param  string $className Class name
	 * @return string 	         Table name
	 */
	protected function getTableName(string $className) : string
	{
		// remove some ..\\..\\..\\ClassName prefix
		$tmp = explode('\\', $className);
		$className = end($tmp);
		$tableName = '';

		foreach (str_split(strtolower($className)) as $key => $char) {
			if ($key !== 0 && ctype_upper($className[$key])) {
				$tableName .= '_';
			}
			$tableName .= $char;
		}

		if (!preg_match('/^[a-zA-Z]{1}[a-zA-Z_]{1,18}$/',$tableName)) {
			throw new \Exception('invalid table name :' . $tableName);
		}
			
		return $tableName;

	}

	/**
	 *  getting meta info from table meta (only for mysql)
	 * @param  string $tableName name of table (probably $this->name)
	 * @return string  			 table meta info and table fields
	 */
	protected function getMetaInfo(string $tableName) : array
	{
		$metaInfo = [];
		$tableFields = [];

		try {
			if (\LAB2\Env::db_type->value === 'mysql') {
				$query = 'DESCRIBE ' . $tableName;

				$metaInfo = $this->PDO->query($query)->fetchAll(\PDO::FETCH_ASSOC);
				$tableFields = $this->PDO->query($query)->fetchAll(\PDO::FETCH_COLUMN);
			}
		} catch (\PDOException $exception) {
			echo $exception->getMessage() . ' : ' . $exceptiosn->getCode();
		}
		return ['meta' => $metaInfo, 'fields' => $tableFields];
	}

	/**
	 *  prepare PDO Statements for curr table using properties
	 * @return void 
	 */
	protected function prepareInsertPDOStatement(): void
	{
		if (is_null($this->name) && is_null($this->metaInfo)) {
			throw new \Exception('bad properties');
		}


		$fields_names = [];
		$vars = [];
		foreach ($this->metaInfo as $field) {
			if ($field['Extra'] !== 'auto_increment') {
				$fields_names[] = $field['Field'];
			}
		}

		$query = 'INSERT INTO ' . $this->name . ' (' . implode(',', $fields_names) . 
				') VALUES (:' . implode(',:', $fields_names) . ')'; 

		$this->PDOInsert = $this->PDO->prepare($query);
	}

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