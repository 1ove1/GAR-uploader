<?php declare(strict_types=1);

namespace GAR\Uploader\Models;

use GAR\Uploader\DB\Table\AbstractTable\QueryTable;
use GAR\Uploader\{DB\DBFacade, DB\PDOAdapter\DBAdapter, DB\Table\TableConcept, Env, Log, Msg};

/**
 * CONCRETE TABLE CLASS
 *
 * IMPLEMENTS ABSTRACTNESS METHODS
 * (OR MODIFIED THEM)
 */
abstract class ConcreteTable implements TableConcept
{
  private QueryTable $table;

  public function __construct(DBAdapter $db)
  {
    $this->table = new QueryTable(
      $db,
      DBFacade::genTableNameByClassName(get_class($this)),
      intval(Env::sqlInsertBuffer->value),
      $this->fieldsToCreate()
    );
    Log::write(
      Msg::LOG_DB_INIT->value,
      $this->getTable()->getName(),
      Msg::LOG_COMPLETE->value
    );
  }

  /**
   * Make select query
   * @param array $fields - fields
   * @param array|null $cond - conditions for where (optional)
   * @param array|null $comp - compare state (optional)
   * @return TableConcept - self
   */
  function select(array $fields, ?array $cond = null, ?array $comp = null): TableConcept
  {
    $this->getTable()->select($fields, $cond, $comp);
    return $this;
  }

  /**
   * Fetch last query
   * @return array - result
   */
  function fetchAll(): array
  {
    return $this->getTable()->fetchAll();
  }

  /**
   * Make insert prepared query (require save())
   * @param array $values - values
   * @return TableConcept - self
   */
  function insert(array $values): TableConcept
  {
    $this->getTable()->insert($values);
    return $this;
  }

  /**
   * Save all changes in tables
   * @return TableConcept - self
   */
  function save(): TableConcept
  {
    $this->getTable()->save();
    return $this;
  }

  /**
   * @return QueryTable - table query subclass
   */
  private function getTable(): QueryTable
  {
    return $this->table;
  }

  /**
   * Return fields that need to create with params
   * @return array|null
   */
  public function fieldsToCreate(): ?array
  {
    return null;
  }


}
