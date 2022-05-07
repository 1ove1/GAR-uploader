<?php

namespace GAR\Uploader\DB\PDOAdapter;

interface InsertTemplate
{
  function exec(DBAdapter $db, array $values) : mixed;
  function save(DBAdapter $db): mixed;
}