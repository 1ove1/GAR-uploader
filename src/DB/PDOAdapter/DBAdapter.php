<?php

namespace GAR\Uploader\DB\PDOAdapter;

use GAR\Uploader\DB\Table\AbstractTable\Container\QueryContainer;

interface DBAdapter
{
  function rawQuery(QueryContainer $query) : self;
  function fetchAll(int $flag) : mixed;
  function prepare(string $template) : mixed;
  function getInsertTemplate(string $tableName,
                             array $fields,
                             int $stagesCount = 1): InsertTemplate;
}