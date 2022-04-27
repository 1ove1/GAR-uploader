<?php declare(strict_types=1);

namespace GAR\Uploader\DB\PDOAdapter;

use RuntimeException;
use PDO;
use PDOStatement;

/**
 * Contains all parameters of current connection
 */
class PDOElem
{
  /**
   * @var PDO|null - curr instance of db connection
   */
  private ?PDO $instance = null;

  /**
   * @var PDOStatement|null - contains last result of query method
   */
  private ?PDOStatement $lastQuery = null;


  /**
   * @param string $dbType - type of curr db
   * @param string $db - curr db
   * @param string $host - host
   * @param string $user - username
   */
  function __construct(
    private readonly string $dbType,
    private readonly string $db,
    private readonly string $host,
    private readonly string $user
  )
  {}


  /**
   * @return PDO|null - curr instance of PDO object
   */
  public function getInstance(): ?PDO
  {
    return $this->instance;
  }

  /**
   * Set instance by PDO object
   * @param PDO $connection - ready PDO object
   * @return void
   */
  private function setInstance(PDO $connection): void
  {
    if (is_null($this->getInstance())) {
      $this->instance = $connection;
    }
  }

  /**
   * Realize connect via PDO by password
   * @param string $pass - password to db
   * @return void
   */
  public function connect(string $pass) : void
  {
    if (is_null($this->getInstance())) {
      $this->setInstance($this->initPDO($pass));
    }
  }

  /**
   * Return ready PDO object
   * @param string $pass - password to db
   * @return PDO - ready PDO object
   */
  private function initPDO(string $pass) : PDO
  {
    return new PDO(
      sprintf(
        "%s:dbname=%s;host=%s",
              $this->getDbType(), $this->getDb(),
              $this->getHost()
      ),
      $this->getUser(),
      $pass,
    );
  }


  /**
   * Make SQL query with validation
   * @param string $SQL - raw SQL code
   * @return $this
   */
  public function query(string $SQL) : self
  {
    if ($this->validSQL($SQL)) {
      $res = $this->getInstance()->query($SQL);
      $this->setLastQuery($res);
    }

    return $this;
  }

  /**
   * @param string $SQL - checked SQL query
   * @return bool - result of validation
   */
  private function validSQL (string $SQL) : bool
  {
    if (empty($SQL)) {
      throw new RuntimeException(
        'PDOElem query error: empty query argument'
      );
    } else if (is_null($this->getInstance())) {
      throw new RuntimeException(
        'PDOElem query error: PDO Object are not exists'
      );
    }
    return true;
  }

  /**
   * @param int $flag - standard PDO flag
   * @return array|false - fetch result
   */
  public function fetchAll(int $flag) : array|false
  {
    return $this->getLastQuery()?->fetchAll($flag);
  }

  /**
   * @return PDOStatement|null
   */
  public function getLastQuery(): ?PDOStatement
  {
    return $this->lastQuery;
  }

  /**
   * @param PDOStatement|null $lastQuery
   */
  public function setLastQuery(?PDOStatement $lastQuery): void
  {
    if ($lastQuery) {
      $this->lastQuery = $lastQuery;
    } else {
      throw new RuntimeException(
        'PDOElem error: bad query'
      );
    }
  }


  /**
   * @return string - db type
   */
  public function getDbType(): string
  {
    return $this->dbType;
  }

  /**
   * @return string - hostname
   */
  public function getHost(): string
  {
    return $this->host;
  }

  /**
   * @return string - db name
   */
  public function getDb(): string
  {
    return $this->db;
  }

  /**
   * @return string - username
   */
  public function getUser(): string
  {
    return $this->user;
  }


}