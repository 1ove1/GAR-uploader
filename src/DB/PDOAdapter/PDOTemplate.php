<?php

namespace GAR\Uploader\DB\PDOAdapter;

use RuntimeException;
use PDOStatement;


class PDOTemplate implements InsertTemplate
{
  /**
   * @var PDOStatement|null - prepared statement for PDO exec
   */
  private ?PDOStatement $state = null;
  /**
   * @var string - name of table
   */
  private readonly string $tableName;
  /**
   * @var int - stages count
   */
  private readonly int $stagesCount;
  /**
   * @var int - current stages in template
   */
  private int $currStage = 0;
  /**
   * @var array - buffer of stage values
   */
  private array $stageBuffer = [];
  /**
   * @var array - template fields
   */
  private readonly array $fields;
  /**
   * @var string - template code
   */
  private string $template;

  /**
   * @param string $tableName
   * @param array $fields
   * @param int $stagesCount
   */
  public function __construct(string $tableName, array $fields, int $stagesCount = 1)
  {
    $this->isValid($tableName, $fields, $stagesCount);

    $this->tableName = $tableName;
    $this->fields = $fields;
    $this->stagesCount = $stagesCount;
  }

  /**
   * Create exception if input is incorrect
   * @param string $tableName - name of table
   * @param array $fields - fields to create
   * @param int $stagesCount - stage count
   * @return void
   */
  public function isValid(string $tableName, array $fields, int $stagesCount) : void
  {
    if ($stagesCount < 1) {
      throw new RuntimeException(
        'PDOTemplate error: stages buffer needs to be more than 0'
      );
    } else if (empty($fields)) {
      throw new RuntimeException(
        'PDOTemplate error: stages buffer needs to be more than 0'
      );
    } else if (empty($tableName)) {
      throw new RuntimeException(
        'PDOTemplate error: stages buffer needs to be more than 0'
      );
    }
  }

  /**
   * Prepare statement to execute
   * @param int $stageCount - count of stages vars
   * @return void - string PDO template
   */
  public function genTemplate(DBAdapter $db, int $stageCount) : void
  {
    $this->template = sprintf(
      'INSERT INTO %s (%s) VALUES %s',
      $this->getTableName(),
      implode(', ', $this->getFields()),
      $this->genVars($stageCount),
    );

    $this->setState($db, $this->template);
  }

  /**
   * Return vars in string view (?, ?, ..., ?)
   * @return string - vars in string view
   */
  public function genVars(int $stageCount) : string
  {
    $vars = [];

    for ($stage = $stageCount; $stage > 0; $stage--) {
      $temp = [];
      foreach ($this->getFields() as $ignored) {
        $temp[] = '? ';
      }
      $vars[] = '(' . implode(', ', $temp) . ')';
    }

    return implode(', ', $vars);
  }

  /**
   * Execute template with bind values (use lazy method)
   * @param DBAdapter $db - database connection
   * @param array $values -
   * @return PDOStatement
   */
  function exec(DBAdapter $db, array $values) : PDOStatement
  {
    if (is_null($this->getState())) {
      $this->setState($db, $this->getStagesCount());
    }
    if (count($this->getFields()) === count($values)) {
      $this->setStageBuffer($values);
      $this->incCurrStage();

      if ($this->getCurrStage() === $this->getStagesCount()) {
        $this->save($db);
      }
    }
    return $this->getState();
  }

  /**
   * @return PDOTemplate - save changes (require for lazy insert)
   */
  function save(DBAdapter $db): PDOTemplate
  {
    if (!empty($this->getStageBuffer())) {
      if ($this->getCurrStage() < $this->getStagesCount()) {
        $this->genTemplate($db, $this->getCurrStage());
        $this->getState()?->execute($this->getStageBuffer());
        $this->genTemplate($db, $this->getStagesCount());
      } else {
          $this->getState()?->execute($this->getStageBuffer());
      }

      $this->setStageBuffer(null);
      $this->incCurrStage(null);
    }
    return $this;
  }


  /**
   * @return PDOStatement|null
   */
  public function getState(): ?PDOStatement
  {
    return $this->state;
  }

  /**
   * @param DBAdapter $db
   * @param string $template
   * @return void
   */
  private function setState(DBAdapter $db, string $template): void
  {
    $this->state = $db->prepare($template);
  }

  /**
   * @return string
   */
  public function getTableName(): string
  {
    return $this->tableName;
  }

  /**
   * @return int
   */
  public function getStagesCount(): int
  {
    return $this->stagesCount;
  }

  /**
   * @return array
   */
  public function getFields(): array
  {
    return $this->fields;
  }

  /**
   * @return string
   */
  public function getTemplate(): string
  {
    return $this->template;
  }

  /**
   * @return int
   */
  public function getCurrStage(): int
  {
    return $this->currStage;
  }

  /**
   * @param int|null $value
   */
  public function incCurrStage(?int $value = 1): void
  {
    if (is_null($value)) {
      $this->currStage = 0;
    } else {
      $this->currStage = $this->currStage + $value;
    }
  }

  /**
   * @return array
   */
  public function getStageBuffer(): array
  {
    return $this->stageBuffer;
  }

  /**
   * @param array|null $stageBuffer
   */
  public function setStageBuffer(?array $stageBuffer): void
  {
    if (is_null($stageBuffer)) {
      $this->stageBuffer = [];
    } else {
      $this->stageBuffer = array_merge(
        $this->stageBuffer, array_values($stageBuffer)
      );
    }
  }

}