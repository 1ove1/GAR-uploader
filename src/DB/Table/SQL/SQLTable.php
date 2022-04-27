<?php

namespace GAR\Uploader\DB\Table\SQL;

use GAR\Uploader\DB\PDOAdapter\PDOElem;
use GAR\Uploader\DB\PDOAdapter\PDOTemplate;
use RuntimeException;

class SQLTable extends MetaTable implements SQL
{
  /**
   * @var PDOTemplate|null - PDO template for insert
   */
  private readonly ?PDOTemplate $insTemple;

  /**
   * @var integer - max lazy insert step
   */
  private readonly int $maxInsStage;

  /**
   * @var array - buffer for stages
   */
  private array $stageBuffer = [];

  /**
   * @var int - curr stage of insert buffer
   */
  private int $currInsStage = 1;

  /**
   * @param PDOElem $db
   * @param string $tableName
   * @param int $maxInsStages
   */
  public function __construct(PDOElem $db, string $tableName, int $maxInsStages)
  {
    parent::__construct($db, $tableName);
    $this->insTemple = new PDOTemplate($db);
    $this->maxInsStage = $maxInsStages;

    $this->insTemple->prepareINS($this->getName(), $this->getFields(), $maxInsStages);
  }

  function select(array $fields, ?array $cond = null, ?array $comp = null): SQL
  {
    $query = sprintf(
      'SELECT %s FROM %s',
      implode(', ', $fields),
      $this->getName(),
    );

    if (isset($cond) && isset($comp)) {
      $formattedWhere = [];
      foreach ($comp as $field => $value) {
        $sign = array_shift($cond);
        $formattedWhere[] = $field . $sign . $value;
        $cond[] = $sign;
      }

      $query .= sprintf(
        ' WHERE %s',
        implode( ' AND ', $formattedWhere)
      );
    }

    $this->getDb()->query($query);

    return $this;
  }

  function insert(array $values): SQL
  {
    if ($this->getCurrInsStage() === $this->getMaxInsStage()) {
      $this->save();
    }

    if (count($this->getFields()) === count($values)) {
      $this->setStageBuffer($values);
      $this->incCurrInsStage();

    } else {
      throw new RuntimeException(
        'SQLTable error: values len are not equal to fields len'
      );
    }

    return $this;
  }

  function save(): SQL
  {
    $buffer = $this->getStageBuffer();

    if (!empty($buffer)) {
      $this->getInsTemple()->exec($buffer);
      $this->setStageBuffer(null);
      $this->incCurrInsStage(null);
    }


    return $this;
  }

  /**
   * @return int
   */
  private function getMaxInsStage(): int
  {
    return $this->maxInsStage;
  }

  /**
   * @return PDOTemplate|null
   */
  private function getInsTemple(): ?PDOTemplate
  {
    return $this->insTemple;
  }

  /**
   * @return array
   */
  private function getStageBuffer(): array
  {
    return $this->stageBuffer;
  }

  /**
   * @param array|null $stageBuffer
   */
  private function setStageBuffer(?array $stageBuffer): void
  {
    if (is_null($stageBuffer)) {
      $this->stageBuffer = [];
    } else {
      $this->stageBuffer = array_merge($this->stageBuffer, array_values($stageBuffer));
    }
  }

  /**
   * @return int
   */
  public function getCurrInsStage(): int
  {
    return $this->currInsStage;
  }

  /**
   * @param int|null $currInsStage
   */
  public function incCurrInsStage(?int $currInsStage = 1): void
  {
    if (is_null($currInsStage)) {
      $this->currInsStage = 1;
    } else {
      $this->currInsStage += $currInsStage;
    }
  }

}