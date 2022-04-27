<?php

namespace GAR\Uploader\DB\PDOAdapter;

use RuntimeException;
use PDOStatement;


class PDOTemplate
{
  /**
   * @var PDOStatement|null - prepared statement for PDO exec
   */
  private ?PDOStatement $state = null;

  /**
   * @var PDOElem - curr pdo elem
   */
  private PDOElem $pdoElem;

  /**
   * @var string - name of table
   */
  private string $tableName;

  /**
   * @var int - stages count
   */
  private int $stagesCount;

  /**
   * @var array - template fields
   */
  private array $fields;

  /**
   * @param PDOElem $pdoElem
   */
  public function __construct(PDOElem $pdoElem)
  {
    $this->pdoElem = $pdoElem;
  }


  /**
   * Prepare statement to execute
   * @param string $tableName - name of table
   * @param array $fields - fields that need to insert
   * @param int $stages - count of insert stages
   * @return $this
   */
  public function prepareINS(string $tableName, array $fields, int $stages = 1) : self
  {
    $formattedVars = [];

    if ($stages < 1) {
      throw new RuntimeException(
        'PDOTemplate error: stages buffer needs to be more than 0'
      );
    }

    for ($stage = $stages; $stage > 0; $stage--) {
      $temp = [];
      foreach ($fields as $ignored) {

        $temp[] = '? ';
      }
      $formattedVars[] = '(' . implode(', ', $temp) . ')';
    }

    $formattedQuery = sprintf(
      'INSERT INTO %s (%s) VALUES %s',
      $tableName, implode(', ', $fields), implode(', ', $formattedVars),
    );

    $this->state = $this->getPDOElem()->getInstance()->prepare($formattedQuery);
    $this->setTableName($tableName);
    $this->setStagesCount($stages);
    $this->setFields($fields);

    return $this;
  }

  /**
   * Execute template
   * @param array $values - values for execute
   * @return $this
   */
  public function exec(array $values) : self
  {
    $newStageCount = count($values) / count($this->getFields());

    if ($this->execValid($newStageCount)) {
      if ($newStageCount < $this->getStagesCount()) {
        $oldStageCount = $this->getStagesCount();

        $this->prepareINS($this->getTableName(), $this->getFields(), $newStageCount);
        $this->getState()->execute($values);
        $this->prepareINS($this->getTableName(), $this->getFields(), $oldStageCount);

      } else {
        $this->getState()->execute($values);
      }
    }

    return $this;
  }

  /**
   * Validation for exec
   * @param $newStageCount - stage count in new input
   * @return bool
   */
  private function execValid($newStageCount) : bool
  {
    if (is_null($this->getState())) {
      throw new RuntimeException(
        'PDOTemplate error: undefined state, do prepare first'
      );
    }
    if ($newStageCount > $this->getStagesCount()) {
      throw new RuntimeException(
        'PDOTemplate error: values count are too big'
      );
    }

    return true;
  }

  /**
   * Getter for PDOStatement
   * @return PDOStatement|null
   */
  public function getState(): ?PDOStatement
  {
    return $this->state;
  }

  /**
   * Getter for PDOElem
   * @return PDOElem
   */
  public function getPDOElem() : PDOElem
  {
    return $this->pdoElem;
  }

  /**
   * @return string
   */
  public function getTableName(): string
  {
    return $this->tableName;
  }

  /**
   * @param string $tableName
   */
  private function setTableName(string $tableName): void
  {
    $this->tableName = $tableName;
  }

  /**
   * @return int
   */
  public function getStagesCount(): int
  {
    return $this->stagesCount;
  }

  /**
   * @param int $stagesCount
   */
  private function setStagesCount(int $stagesCount): void
  {
    $this->stagesCount = $stagesCount;
  }

  /**
   * @return array
   */
  public function getFields(): array
  {
    return $this->fields;
  }

  /**
   * @param array $fields
   */
  public function setFields(array $fields): void
  {
    $this->fields = $fields;
  }


}