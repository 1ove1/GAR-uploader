<?php

namespace GAR\Uploader\DB\Table\AbstractTable\SQLFactory;

use InvalidArgumentException;

class SQLGenerator implements SQLFactory
{
  /**
   * Generate single select query by table name and
   * (optional) condition
   * @param string $tableName - name of table
   * @param array $fields - fields in select query
   * @param array|null $cond - 'where' condition sign
   * @param array|null $comp - compare field->values
   * @return SQLQuery - query object
   */
  public static function genSelectQuery(string $tableName,
                                        array  $fields,
                                        ?array $cond = null,
                                        ?array $comp = null) : SQLQuery
  {

    return (new SQLObject())
      ->setType(SQLEnum::SELECT)
      ->setRawSql(self::makeSelect($tableName, $fields, $cond, $comp))
      ->validate(function (string $sqlCode) {
        return preg_match(
          '/SELECT [A-z., ]+ FROM [A-z., ]+ WHERE [A-z][<=>][A-z]/',
          $sqlCode
        );
      });
  }

  /**
   * Generate describe query (probably work only in mysql?)
   * @param string $tableName - name of table
   * @return SQLQuery - query object
   */
  public static function genMetaQuery(string $tableName) : SQLQuery
  {
    return (new SQLObject())
      ->setRawSql(self::makeMetaQuery($tableName))
      ->setType(SQLEnum::META)
      ->validate(fn() => true);
  }

  /**
   * Generate create table if exists query
   * @param string $tableName - name of table
   * @param array $fieldsWithParams - fields and their params
   * @return SQLQuery - query object
   */
  static function genCreateTableQuery(string $tableName,
                                      array $fieldsWithParams): SQLQuery
  {
    return (new SQLObject())
      ->setType(SQLEnum::META)
      ->setRawSql(self::makeCreateTableQuery($tableName, $fieldsWithParams))
      ->validate(fn() => true);
  }

  /**
   * Return show tables query
   * @return SQLQuery - query object
   */
  static function genShowTableQuery() : SQLQuery
  {
    return (new SQLObject())
      ->setType(SQLEnum::META)
      ->setRawSql('SHOW TABLES')
      ->validate(fn() => true);
  }


  /**
   * Make select query by params
   * @param string $tableName - name of table
   * @param array $fields - fields for select
   * @param array|null $cond - condition (optional)
   * @param array|null $comp - compare field => value (optional)
   * @return string - query string
   */
  public static function makeSelect(string $tableName,
                                    array $fields,
                                    ?array $cond = null,
                                    ?array $comp = null) : string
  {
    $query = sprintf(
      'SELECT %s FROM %s',
      implode(', ', $fields),
      $tableName,
    );

    if (isset($cond) && isset($comp)) {
      $formattedWhere = [];
      foreach ($comp as $field => $value) {
        $sign = array_shift($cond);
        $formattedWhere[] = $field . $sign . $value;
        $cond[] = $sign;
      }
      $query .= sprintf(
      ' WHERE %s',
      implode( ' AND ', $formattedWhere)
      );
    }

    return $query;
  }

  /**
   * Make meta query (describe)
   * @param string $tableName - name of table
   * @return string - query string
   */
  public static function makeMetaQuery(string $tableName) : string
  {
    return sprintf(
      'DESCRIBE %s',
      $tableName
    );
  }

  /**
   * Make create table if exists query string
   * @param string $tableName - name of table
   * @param array $fieldsWithParams - fields with params
   * @return string - query string
   */
  public static function makeCreateTableQuery(string $tableName, array $fieldsWithParams) : string
  {
    $formattedFields = [];

    foreach ($fieldsWithParams as $field => $params) {
      if (empty($params)) {
        throw new InvalidArgumentException(sprintf(
          "field %s should contains type params!",
          $field
        ));
      }
      $formattedFields[] = sprintf(
        "%s %s",
        $field,
        implode(' ', $params)
      );
    }
    return sprintf(
      'DROP TABLE IF EXISTS %1$s; CREATE TABLE %1$s (%2$s)',
      $tableName,
      implode(', ', $formattedFields));
  }
}

