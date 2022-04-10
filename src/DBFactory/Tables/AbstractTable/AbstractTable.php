<?php declare(strict_types=1);

namespace LAB2\DBFactory\Tables\AbstractTable;


/**
 * ABSTRACT TABLE INTERFACE
 * 
 * DEFINES ALL NEEDED METHODS FOR DB COMMUNICATION
 */
abstract class AbstractTable
{

	/**
	 *  name of table
	 * @var null
	 */
	protected ?string $name = null;

	/**
	 *  table fields
	 * @var null
	 */
	protected ?array $fields = null;

	/**
	 *  full information about table fields
	 * @var null
	 */
	protected ?array $metaInfo = null;

	/**
	 *  PDO object 
	 * @var null
	 */
	protected ?\PDO $PDO 	= null;

	/**
	 * PDO statement for insert
	 * @var null
	 */
	protected ?\PDOStatement $PDOInsert = null;


	/**
	 * basic construct that take current PDO connection
	 * and getting all needed dependencies like
	 * name of table by class name concrete model,
	 * actual fields of table and other		
	 * @param \PDO $connection connected PDO object
	 */
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

	/**
	 *  DATABASE META INFO
	 */

	/**
	 * Class name to class table (CamelCase to snake_case)
	 * @param  string $className Class name
	 * @return string 	         Table name
	*/
	protected abstract function getTableName(string $className) : string;

	/**
	 *  getting meta info from table meta (only for mysql)
	 * @param  string $tableName name of table (probably $this->name)
	 * @return string  			 table meta info and table fields
	 */
	protected abstract function getMetaInfo(string $tableName) : array;

	/**
	 *  prepare PDO Statements for curr table using properties
	 * @return void 
	 */
	protected abstract function prepareInsertPDOStatement(): void;

	/**
	 * DATABASE QUERIES
	 */
	
	/**
	 *  Select method (simple sql query)
	 * @param  string      $fields    fields that needs to select
	 * @param  string|null $condition WHERE condition
	 * @param  array|null  $element   WHERE element for condition
	 * @return array 				  query result
	 */
	public abstract function select(array|string $fields = '*', ?string $condition = null, ?array $element = null) : array;

	/**
	 *  insert query
	 * @param  array  $fields_values array with field => value struct 
	 * @return voids
	 */
	public abstract function insert(array $fields_values) : void;
}