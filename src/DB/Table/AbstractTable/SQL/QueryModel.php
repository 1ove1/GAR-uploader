<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Table\AbstractTable\SQL;

use GAR\Uploader\DB\Table\AbstractTable\SQL\DeleteQuery;
use GAR\Uploader\DB\Table\AbstractTable\SQL\EndQuery;
use GAR\Uploader\DB\Table\AbstractTable\SQL\UpdateQuery;

interface QueryModel
{
  function insert(array $values) : EndQuery;
  function forceInsert(array $values) : EndQuery;
  function update(string $field, string $value) : UpdateQuery;
  function delete() : DeleteQuery;
  function select(array $fields, array $anotherTables) : SelectQuery;
}