<?php

namespace GAR\Tests;

use GAR\Uploader\DB\Table\ConcreteTable;
use GAR\Uploader\DB\Table\Query;

class Test extends ConcreteTable implements Query
{
  #[ArrayShape(['id' => "string[]", 'message' => "string[]"])] public function fieldsToCreate(): ?array
  {
    return ['id' => ['BIGINT UNSIGNED'], 'message' => ['CHAR(50) NOT NULL']];
  }

}