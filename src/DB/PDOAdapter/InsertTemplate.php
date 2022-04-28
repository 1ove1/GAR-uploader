<?php

namespace GAR\Uploader\DB\PDOAdapter;

interface InsertTemplate
{
  function exec(DBAdapter $db, array $values) : mixed;
  // --Commented out by Inspection (28.04.2022, 19:27):function save(): mixed;
}