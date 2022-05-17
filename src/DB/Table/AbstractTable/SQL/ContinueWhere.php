<?php

namespace GAR\Uploader\DB\Table\AbstractTable\SQL;

interface ContinueWhere
{
  function andWhere(string $field, string $sign, int|string $value) : ContinueWhere;
  function orWhere(string $field, string $sign, int|string $value) : ContinueWhere;
  function reset() : QueryModel;
  function save() : array;
}