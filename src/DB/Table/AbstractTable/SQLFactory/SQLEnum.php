<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Table\AbstractTable\SQLFactory;

enum SQLEnum
{
  case INSERT;
  case SELECT;
  case META;
}