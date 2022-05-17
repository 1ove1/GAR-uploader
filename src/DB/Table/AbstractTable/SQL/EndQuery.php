<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Table\AbstractTable\SQL;

interface EndQuery
{
  function save(): array;
  function reset(): QueryModel;
}