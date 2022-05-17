<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Table\AbstractTable\Container;

interface QueryContainer
{
  function getType() : QueryTypes;
  function getRawSql() : string;
  function isValid() : bool;
}