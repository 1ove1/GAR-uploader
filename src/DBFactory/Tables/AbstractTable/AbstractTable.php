<?php declare(strict_types=1);

namespace LAB2\DBFactory\Tables\AbstractTable;

use LAB2\DBFactory\Tables\AbstractTable\Queries;
use LAB2\DBFactory\Tables\AbstractTable\MetaTable;
use LAB2\DBFactory\DBFacade;

abstract class AbstractTable
{
	use Queries, MetaTable;

	/**
	 *  name of table
	 * @var null
	 */
	protected ?string  			$name = null;

	/**
	 *  table fields
	 * @var null
	 */
	protected ?array 			$fields = null;

	/**
	 *  full information about table fields
	 * @var null
	 */
	protected ?array   			$metaInfo = null;

	/**
	 *  PDO object 
	 * @var null
	 */
	protected ?\PDO 			$PDO 	= null;

	/**
	 * PDO statement for insert
	 * @var null
	 */
	protected ?\PDOStatement	$PDOInsert = null;


	public function __construct(\PDO $connection) {
		// init PDO
		$this->PDO = $connection;
		// find name using child class name
		$this->name = $this->getTableName(get_class($this));
		// geting meta and fields info
		['meta' => $this->metaInfo, 'fields' => $this->fields] = $this->getMetaInfo($this->name);

		// prepare Insert Statement
		$this->prepareInsertPDOStatement();
	}

}