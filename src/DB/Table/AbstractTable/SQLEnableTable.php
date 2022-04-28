<?php

namespace GAR\Uploader\DB\Table\AbstractTable;

use GAR\Uploader\DB\PDOAdapter\InsertTemplate;
use GAR\Uploader\DB\PDOAdapter\PDOObject;
use GAR\Uploader\DB\PDOAdapter\PDOTemplate;
use GAR\Uploader\DB\Table\AbstractTable\SQLFactory\SQLGenerator;

class SQLEnableTable extends MetaEnableTable implements SQLEnable
{
  /**
   * @var InsertTemplate|null - PDO template for insert
   */
  private readonly ?InsertTemplate $insTemple;

  /**
   * @param PDOObject $db
   * @param string $tableName
   * @param int $maxInsStages
   */
  public function __construct(PDOObject $db, string $tableName, int $maxInsStages)
  {
    parent::__construct($db, $tableName);
    $this->insTemple = new PDOTemplate($tableName, $this->getFields(), $maxInsStages);
  }

  /**
   * Make simple select query
   * @param array $fields - selected fields
   * @param array|null $cond - condition for WHERE
   * @param array|null $comp -
   * @return SQLEnable
   */
  function select(array $fields, ?array $cond = null, ?array $comp = null): SQLEnable
  {
    $this->getDb()->rawQuery(SQLGenerator::genSelectQuery(
      $this->getName(), $fields, $cond, $comp
    ));

    return $this;
  }

  function insert(array $values): SQLEnable
  {
    $this->getInsTemple()->exec($this->getDb(), $values);

    return $this;
  }

  /**
   * save results
   * @return SQLEnableTable - self
   */
  function save(): self
  {
    $this->getInsTemple()->save($this->getDb());
    return $this;
  }

  /**
   * @return PDOTemplate|null
   */
  private function getInsTemple(): ?PDOTemplate
  {
    return $this->insTemple;
  }
}