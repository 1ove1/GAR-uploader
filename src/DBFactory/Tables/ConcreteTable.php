<?php declare(strict_types=1);

namespace LAB2\DBFactory\Tables;

use LAB2\DBFactory\Tables\AbstractTable\{
	AbstractTable, Queries, MetaTable
};

use LAB2\{Log, Msg};


/**
 * CONCRETE TABLE CLASS
 *
 * IMPLEMENTS ABSTRACTTABLE METHODS 
 * (OR MODIFIED THEM)
 */
abstract class ConcreteTable extends AbstractTable
{
	use Queries, MetaTable;

	/**
	 * modified basic construct for some log info
	 * @param \PDO $connection connected PDO object
	 */
	function __construct(\PDO $connection) {
		try {
			parent::__construct($connection);
			
			Log::write(sprintf(
				"%s %s %s",
				Msg::LOG_DB_TABLE->value, 
				$this->name, 
				Msg::LOG_COMPLETE->value
			));
		} catch (PDOException $excp) {
			Log::error($excp);
		} 
	}

}
