<?php

namespace GAR\Uploader\DB\Models;

use GAR\Uploader\DB\Table\AbstractTable\SQL\QueryModel;
use GAR\Uploader\DB\Table\ConcreteTable;
use JetBrains\PhpStorm\ArrayShape;

class ObjLevels extends ConcreteTable implements QueryModel
{
  #[ArrayShape(['id' => "string[]", 'disc' => "string[]"])]
  public function fieldsToCreate(): ?array
  {
    return [
      'id' => [
        'TINYINT UNSIGNED PRIMARY KEY NOT NULL'
      ],
      'disc' => [
        'CHAR(70)'
      ]
    ];
  }
}