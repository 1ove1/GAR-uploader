<?php declare(strict_types=1);

namespace GAR\Uploader\DB\PDOAdapter;

use GAR\Uploader\DB\Table\AbstractTable\SQLFactory\SQLQuery;
use RuntimeException;
use PDO;
use PDOStatement;

/**
 * Contains all parameters of current connection
 */
class PDOObject implements DBAdapter
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
   * @param string $dbName - curr db
   * @param string $host - host
   * @param string $user - username
   */
  function __construct(
    private readonly string $dbType,
    private readonly string $dbName,
    private readonly string $host,
    private readonly string $user,
  )
  {}

  /**
   * Realize connect via PDO by password
   * @param string $pass - password to db
   * @return void
   */
  public function connect(string $pass) : void
  {
    if (is_null($this->getInstance())) {
      $this->setInstance(new PDO(
        sprintf("%s:dbname=%s;host=%s",
          $this->getDbType(), $this->getDbName(), $this->getHost()),
        $this->getUser(), $pass,
      ));
    }
  }

  /**
   * Make SQL query
   * @param SQLQuery $query - sql object
   * @return self
   */
  public function rawQuery(SQLQuery $query) : self
  {
    if ($query->isValid()) {
      $res = $this->getInstance()->query($query->getRawSql());
      $this->setLastQuery($res);
    } else {
      throw new RuntimeException(
        "PDOObject error: invalid sql query '" . $query->getRawSql() . "'"
      );
    }

    return $this;
  }

  /**
   * Prepare template
   * @param string $template - string template query
   * @return PDOStatement - pdo object
   */
  function prepare(string $template): PDOStatement
  {
    return $this->getInstance()->prepare($template);
  }


  /**
   * @param int $flag - standard PDO flag
   * @return array|bool|null - fetch result
   */
  public function fetchAll(int $flag) : array|bool|null
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
        'PDOObject error: bad query'
      );
    }
  }

  /**
   * Set instance by PDO object
   * @param PDO $connection - ready PDO object
   * @return void
   */
  private function setInstance(PDO $connection): void
  {
    $this->instance = $connection;
  }

  /**
   * @return PDO|null - curr instance of PDO object
   */
  public function getInstance(): PDO|null
  {
    return $this->instance;
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
  public function getDbName(): string
  {
    return $this->dbName;
  }

  public function getUser(): string
  {
    return $this->user;
  }

}