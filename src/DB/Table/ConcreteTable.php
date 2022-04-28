<?php declare(strict_types=1);

namespace GAR\Uploader\Models;

use GAR\Uploader\DB\Table\AbstractTable\SQLEnableTable;
use GAR\Uploader\{DB\DBFacade, DB\PDOAdapter\DBAdapter, Env, Log, Msg};

/**
 * CONCRETE TABLE CLASS
 *
 * IMPLEMENTS ABSTRACTNESS METHODS
 * (OR MODIFIED THEM)
 */
abstract class ConcreteTable extends SQLEnableTable
{

  public function __construct(DBAdapter $db)
  {
    parent::__construct(
      $db,
      DBFacade::genTableNameByClassName(get_class($this)),
      intval(Env::sqlInsertBuffer->value)
    );
    Log::write(
      Msg::LOG_DB_INIT->value,
      $this->getName(),
      Msg::LOG_COMPLETE->value
    );
  }


}
