<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Table\AbstractTable\SQLFactory;

class SQLObject implements SQLQuery
{
  /**
   * @var SQLEnum - type of sql query
   */
  private SQLEnum $type;
  /**
   * @var string - raw sql code
   */
  private string $rawSql;
  /**
   * @var bool - result of validation
   */
  private bool $valid;

  /**
   * @param SQLEnum $type - type of sql
   * @return SQLObject - self
   */
  public function setType(SQLEnum $type): self
  {
    $this->type = $type;
    return $this;
  }

  /**
   * @return SQLEnum - type of sql
   */
  function getType(): SQLEnum
  {
    return $this->type;
  }

  /**
   * @param string $rawSql - sql code
   * @return SQLObject - self
   */
  public function setRawSql(string $rawSql): self
  {
    $this->rawSql = $rawSql;
    return $this;
  }

  /**
   * @return string - raw sql
   */
  function getRawSql(): string
  {
    return $this->rawSql;
  }

  /**
   * @param callable $clb - validate function
   * @return $this - self
   */
  public function validate(callable $clb): self
  {
    $this->valid = $clb($this->getRawSql());
    return $this;
  }

  /**
   * @return bool - result of validation
   */
  function isValid(): bool
  {
    return $this->valid;
  }
}