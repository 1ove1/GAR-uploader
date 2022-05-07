<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Table;



interface TableConcept
{
  function select(array $fields,
                  ?array $cond = null,
                  ?array $comp = null): TableConcept;
  function fetchAll(): array;
  function insert(array $values): TableConcept;
  function save(): TableConcept;
  function fieldsToCreate(): ?array;
}