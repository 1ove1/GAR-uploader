<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Table\AbstractTable\SQLFactory;

interface SQLFactory
{
  static function genSelectQuery(string $tableName,
                                 array  $fields,
                                 ?array $cond = null,
                                 ?array $comp = null) : SQLQuery;
  static function genMetaQuery(string $tableName) : SQLQuery;
  static function genCreateTableQuery(string $tableName,
                                      array $fieldsWithParams) : SQLQuery;
  static function genShowTableQuery() : SQLQuery;
//  static function makeInsert(SQLObject $template) : SQLQuery;
//  static function makeInsertPDOTemplate(string $tableName,
//                                        string $fields,
//                                        int $stageCount) : PDOTemplate;


}