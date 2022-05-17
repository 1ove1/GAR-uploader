<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Table\AbstractTable\Container;

enum QueryTypes
{
  case INSERT;
  case SELECT;
  case META;
}