<?php

namespace GAR\Uploader\DB\PDOAdapter;

use GAR\Uploader\DB\Table\AbstractTable\SQLFactory\SQLQuery;

interface DBAdapter
{
  function rawQuery(SQLQuery $query) : self;
  function fetchAll(int $flag) : mixed;
  function prepare(string $template) : mixed;
}