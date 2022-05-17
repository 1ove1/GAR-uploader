<?php

namespace GAR\Uploader\DB\Table\AbstractTable\SQL;

interface UpdateQuery
{
  function where(string $field, string $sign, int|string $value) : ContinueWhere;
  function save() : array;
  function reset() : QueryModel;
}