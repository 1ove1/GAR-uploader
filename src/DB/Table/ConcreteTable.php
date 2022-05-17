<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Table;

use GAR\Uploader\{
  DB\DBFacade,
  DB\PDOAdapter\DBAdapter,
  DB\Table\AbstractTable\SQLBuilder,
  Env,
  Log,
  Msg
};

/**
 * CONCRETE TABLE CLASS
 *
 * IMPLEMENTS ABSTRACTNESS METHODS
 * (OR MODIFIED THEM)
 */
abstract class ConcreteTable extends SQLBuilder
{
  public function __construct(DBAdapter $db)
  {
    parent::__construct(
      $db,
      DBFacade::genTableNameByClassName(get_class($this)),
      intval(Env::sqlInsertBuffer->value),
      $this->fieldsToCreate()
    );
    Log::write(
      Msg::LOG_DB_INIT->value,
      $this->getTableName(),
      Msg::LOG_COMPLETE->value
    );
  }

  protected function fieldsToCreate() : ?array
  {
    return null;
  }
}
