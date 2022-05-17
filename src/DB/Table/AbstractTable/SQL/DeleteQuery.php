<?php

namespace GAR\Uploader\DB\Table\AbstractTable\SQL;

interface DeleteQuery
{
  function where(string $field, string $sign, int|string $value) : ContinueWhere;
  function reset(): QueryModel;
  function save(): array;
}