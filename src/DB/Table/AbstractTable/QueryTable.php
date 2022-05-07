<?php

namespace GAR\Uploader\DB\Table\AbstractTable;

use GAR\Uploader\DB\DBFacade;
use GAR\Uploader\DB\PDOAdapter\InsertTemplate;
use GAR\Uploader\DB\PDOAdapter\PDOObject;
use GAR\Uploader\DB\Table\AbstractTable\SQLFactory\SQLFactory;
use GAR\Uploader\DB\Table\AbstractTable\SQLFactory\SQLGenerator;

class QueryTable extends MetaTable
{
  /**
   * @var InsertTemplate|null - PDO template for insert
   */
  private readonly ?InsertTemplate $insTemple;
  /**
   * @var SQLFactory - factory of sql queries
   */
  private readonly SQLFactory $factory;

  /**
   * Create object of query table
   * @param PDOObject $db
   * @param string $tableName
   * @param int $maxInsStages
   * @param array|null $createOption
   */
  public function __construct(PDOObject $db,
                              string $tableName,
                              int $maxInsStages,
                              ?array $createOption = null)
  {
    parent::__construct($db, $tableName, $createOption);
    $this->factory = new SQLGenerator();

    $this->insTemple = DBFacade::getTemplate(
      $tableName, $this->getFields(), $maxInsStages
    );
  }

  /**
   * Make simple select query
   * @param array $fields - selected fields
   * @param array|null $cond - condition for WHERE
   * @param array|null $comp - values for compare
   * @return QueryTable - self
   */
  function select(array $fields,
                  ?array $cond = null,
                  ?array $comp = null): self
  {
    $this->getDb()->rawQuery($this->getFactory()->genSelectQuery(
      $this->getName(), $fields, $cond, $comp
    ));

    return $this;
  }

  /**
   * Fetching last select query (or another)
   * @return array - array result
   */
  function fetchAll() : array
  {
    return $this->getDb()->fetchAll();
  }

  /**
   * Make insert query by template
   * @param array $values - values for insert
   * @return QueryTable - self
   */
  function insert(array $values): self
  {
    $this->getInsTemple()->exec($this->getDb(), $values);

    return $this;
  }

  /**
   * save results
   * @return QueryTable - self
   */
  function save(): self
  {
    $this->getInsTemple()->save($this->getDb());
    return $this;
  }

  /**
   * @return InsertTemplate|null
   */
  private function getInsTemple(): ?InsertTemplate
  {
    return $this->insTemple;
  }

  private function getFactory() : SQLFactory
  {
    return $this->factory;
  }
}