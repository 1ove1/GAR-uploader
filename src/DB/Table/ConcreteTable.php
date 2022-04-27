<?php declare(strict_types=1);

namespace GAR\Uploader\Models;

use GAR\Uploader\{DB\PDOAdapter\PDOElem, DB\Table\SQL\SQLTable, Log, Msg, Env};

/**
 * CONCRETE TABLE CLASS
 *
 * IMPLEMENTS ABSTRACTNESS METHODS
 * (OR MODIFIED THEM)
 */
abstract class ConcreteTable extends SQLTable
{

  public function __construct(PDOElem $db)
  {
    parent::__construct($db, get_class($this), intval(Env::sqlInsertBuffer->value));
    Log::write(
      Msg::LOG_DB_INIT->value,
      $this->getName(),
      Msg::LOG_COMPLETE->value
    );
  }
}
