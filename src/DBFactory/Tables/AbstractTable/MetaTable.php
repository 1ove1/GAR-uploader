<?php declare(strict_types=1);

namespace GAR\Uploader\DBFactory\Tables\AbstractTable;


/**
 * TRAIT META TABLE
 *
 * IMPLEMETS SOME METHODS FROM ABSTRACTTABLE INTERFACE
 */
trait MetaTable
{

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
			if (\GAR\Uploader\Env::db_type->value === 'mysql') {
				$query = 'DESCRIBE ' . $tableName;

				$metaInfo = $this->PDO->query($query)->fetchAll(\PDO::FETCH_ASSOC);
				$tableFields = $this->PDO->query($query)->fetchAll(\PDO::FETCH_COLUMN);
			}
		} catch (\PDOException $exception) {
			echo $exception->getMessage() . ' : ' . $exception->getCode();
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
}