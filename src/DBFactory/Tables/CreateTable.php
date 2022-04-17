<?php declare(strict_types=1);

namespace LAB2\DBFactory\Tables;

/**
 * CREATE INTERFACE
 *
 * DEFINES METHOD getFields THATH RETURNS 
 * REQUIERS FIELDS THAT NEED CREATE IN CREATED TABLE
 */
interface CreateTable
{
	/**
	 * return fields and their params that need to create
	 * in new table
	 * @return array fields and their params
	 */
	function getFieldsToCreate() : array;

	/**
	 * create table useing curr connection, name of table
	 * and fields
	 * @param  \PDO   $connection     connected PDO object
	 * @param  string $nameOfTable    name of table
	 * @param  array  $fieldsToCreate fields
	 * @return void
	 */
	function createTable(\PDO $connection, string $nameOfTable, array $fieldsToCreate) : void;
}