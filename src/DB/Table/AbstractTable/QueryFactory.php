<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Table\AbstractTable;

use GAR\Uploader\DB\Table\AbstractTable\Container\QueryContainer;

interface QueryFactory
{
  /**
   * Generate query container manually
   *
   * @param string $query - query string
   * @param callable|null $validate - validate callback
   * @return QueryContainer
   */
  static function customQuery(string $query,
                              ?callable $validate = null) : QueryContainer;

  /**
   * Generate describe query (probably work only in mysql?)
   * @param string $tableName - name of table
   * @return QueryContainer - query object
   */
  static function genMetaQuery(string $tableName) : QueryContainer;

  /**
   * Generate create table if exists query
   * @param string $tableName - name of table
   * @param array $fieldsWithParams - fields and their params
   * @return QueryContainer - query object
   */
  static function genCreateTableQuery(string $tableName,
                               array $fieldsWithParams): QueryContainer;

  /**
   * Return show tables query
   * @return QueryContainer - query object
   */
  static function genShowTableQuery() : QueryContainer;
}