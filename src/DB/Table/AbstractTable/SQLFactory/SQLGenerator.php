<?php

namespace GAR\Uploader\DB\Table\AbstractTable\SQLFactory;

use InvalidArgumentException;

class SQLGenerator implements SQLFactory
{
  public static function genSelectQuery(string $tableName,
                                        array  $fields,
                                        ?array $cond = null,
                                        ?array $comp = null) : SQLQuery
  {

    return (new SQLObject())->setType(SQLEnum::SELECT)
                            ->setRawSql(self::makeSelect(
                              $tableName, $fields,
                              $cond, $comp
                            ))
                            ->validate(function (string $sqlCode) {
                              return preg_match(
                                '/SELECT [A-z., ]+ FROM [A-z., ]+ WHERE [A-z][<=>][A-z]/',
                                $sqlCode
                              );
                            });
  }

  public static function genMetaQuery(string $tableName) : SQLQuery
  {
    return (new SQLObject())->setRawSql(self::makeMetaQuery($tableName))
                            ->setType(SQLEnum::META)
                            ->validate(fn() => true);
  }

  static function genCreateTableQuery(string $tableName,
                                      array $fieldsWithParams): SQLQuery
  {
    return (new SQLObject())->setType(SQLEnum::META)
                            ->setRawSql(sprintf(
                              'DROP TABLE IF EXISTS %1$s; CREATE TABLE %1$s (%2$s)',
                              $tableName,
                              self::makeCreateTableQuery($fieldsWithParams)
                            ))
                            ->validate(fn() => true);
  }

  static function genShowTableQuery() : SQLQuery
  {
    return (new SQLObject())->setType(SQLEnum::META)
                            ->setRawSql('SHOW TABLES')
                            ->validate(fn() => true);
  }

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

  public static function makeMetaQuery(string $tableName) : string
  {
    return sprintf(
      'DESCRIBE %s',
      $tableName
    );
  }

  public static function makeCreateTableQuery(array $fieldsWithParams) : string
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
    return implode(', ', $formattedFields);
  }
}

