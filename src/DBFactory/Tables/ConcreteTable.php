<?php declare(strict_types=1);

namespace GAR\Uploader\DBFactory\Tables;

use GAR\Uploader\DBFactory\Tables\AbstractTable\{
	AbstractTable, Queries, MetaTable
};
use GAR\Uploader\DBFactory\Tables\CreateTable;
use GAR\Uploader\{Log, Msg, Env};

/**
 * CONCRETE TABLE CLASS
 *
 * IMPLEMENTS ABSTRACTTABLE METHODS 
 * (OR MODIFIED THEM)
 */
abstract class ConcreteTable extends AbstractTable implements CreateTable
{
	use Queries, MetaTable;

	/**
	 * modified basic construct for some log info
	 * @param \PDO $connection connected PDO object
	 */
	function __construct(\PDO $connection) {
		try {
			if (!empty($this->getFieldsToCreate())) { 
				$createFields = $this->getFieldsToCreate();
				$createTableName = $this->getTableName(get_class($this));

				$this->createTable(
					$connection,
					$createTableName,
					$createFields
				);
			}

			parent::__construct($connection, intval(Env::sqlInsertBuffer->value));
			
			Log::write(
				Msg::LOG_DB_TABLE->value, 
				$this->name, 
				Msg::LOG_COMPLETE->value
			);
		} catch (\PDOException $excp) {
			Log::error($excp);
		}
	}

	/**
	 * default implementation of method
	 * @return array empty
	 */
	public function getFieldsToCreate() : array
	{
		return [];
	}

	/**
	 * create table method
	 * @param  \PDO   $connection     connected PDO object
	 * @param  string $nameOfTable    table name
	 * @param  array  $fieldsToCreate fields to create
	 * @return void
	 */
	public function createTable(\PDO $connection, string $nameOfTable, array $fieldsToCreate) : void
	{
		if (!$this->tableDropConfirmIfExists($connection, $nameOfTable)) {
			return;
		}


		Log::write(
			Msg::LOG_DB_CREATE->value, $nameOfTable,
			Msg::LOG_DB_WITH_FIELDS->value, 
			implode(', ', array_keys($fieldsToCreate))
		);

		$formatedFields = [];

		foreach ($fieldsToCreate as $field => $params) {
			if (empty($params)) {
				throw new \InvalidArgumentException(sprintf(
					"field %s should contains type params!",
					$field
				));
			}

			$formatedFields[] = sprintf(
				"%s %s",
				$field,
				implode(' ', $params)
			);
		}

		$createQuery = sprintf(
			"DROP TABLE IF EXISTS %s; CREATE TABLE %s (%s)", 
			$nameOfTable,
			$nameOfTable,
			implode(', ', $formatedFields) 
			);
 
		$connection->exec($createQuery);
	}

	private function tableDropConfirmIfExists(\PDO $connection, string $nameOfTable) : bool
	{
		$tableList = $connection->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);
		
		if (in_array($nameOfTable, $tableList)) {
			do {
				$confirm = readline(
					$nameOfTable . Msg::LOG_DB_DROP_CONFIRM->value
				);
			} while(!preg_match('/[YyNnДдНн]+/', $confirm));
			
			if (preg_match("/[NnНн]/", $confirm)) {
				return FALSE;
			} 
		}

		return TRUE;
	}
}
