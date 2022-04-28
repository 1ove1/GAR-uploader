<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Table\AbstractTable\SQLFactory;

interface SQLQuery
{
  function getType() : SQLEnum;
  function getRawSql() : string;
  function isValid() : bool;
}