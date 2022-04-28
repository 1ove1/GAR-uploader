<?php

namespace GAR\Uploader\DB\Table\AbstractTable;

use GAR\Uploader\DB\PDOAdapter\DBAdapter;
use GAR\Uploader\DB\Table\AbstractTable\SQLFactory\SQLGenerator;
use JetBrains\PhpStorm\ArrayShape;
use PDO;

class MetaEnableTable implements MetaEnable
{
  /**
   * @var DBAdapter - PDO object
   */
  private readonly DBAdapter $db;
  /**
   * @var string - name of table
   */
  private readonly string $name;
  /**
   * @var array - table fields
   */
  private array $fields;
  /**
   * @var array - full information about table
   */
  private readonly array $metaInfo;

  /**
   * @param DBAdapter $db
   * @param string $tableName
   */
  public function __construct(DBAdapter $db, string $tableName)
  {
    $this->db = $db;
    $this->name = $tableName;
    if ($this->setFieldsToCreate() !== null) {
      $this->createTable($tableName);
    }

    [$this->metaInfo, $this->fields] = $this->getMetaInfoAndFields($tableName);
  }

  /**
   *  getting meta info from table meta (only for mysql)
   * @param string $tableName name of table (probably $this->name)
   * @return array
   */
  #[ArrayShape(['metaInfo' => "array|false", 'fields' => "array|false"])]
  private function getMetaInfoAndFields(string $tableName) : array
  {
    $query = SQLGenerator::genMetaQuery($tableName);

    $metaInfo = $this->getDb()->rawQuery($query)->fetchAll(PDO::FETCH_ASSOC);
    $tableFields = $this->getDb()->rawQuery($query)->fetchAll(PDO::FETCH_COLUMN);

    return [$metaInfo, $tableFields];
  }

  /**
   * Create table using curr connected, name of table and fields
   * @param string $tableName
   * @return void
   */
  private function createTable(string $tableName) : void
  {
    if (!$this->tableExistsAndDropCheck($tableName)) {
      return;
    }

    $this->getDb()->rawQuery(SQLGenerator::genCreateTableQuery(
      $this->getName(), $this->setFieldsToCreate()
    ));
  }

  /**
   * Check table existing and ask user to drop it if exist
   * @param string $tableName - name of table
   * @return bool - user decision
   */
  public function tableExistsAndDropCheck(string $tableName) : bool
  {
    $connection = $this->getDb();
    $tableList = $connection->rawQuery(SQLGenerator::genShowTableQuery())
                            ->fetchAll(PDO::FETCH_COLUMN);
    $userInput = '';

    if (in_array($tableName, $tableList)) {
      do {
        $userInput = readline(
          'create new ' . $tableName . '? [Y/n]: '
        );
      } while (!preg_match('/[YyNnДдНн]+/', $userInput));
    }
    return !preg_match("/[NnНн]/", $userInput);
  }

  /**
   * Return name of table
   * @return string - name of table
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * Return mta info about table
   * @return array|null - meta info about table
   */
  public function getMetaInfo(): ?array
  {
    return $this->metaInfo;
  }

  /**
   * Return fields for curr table
   * @return array|null - fields
   */
  function getFields(): ?array
  {
    return $this->fields;
  }

  /**
   * Set the custom fields that need to create (null if not)
   * @return array|null - fields and their params
   */
  function setFieldsToCreate(): ?array
  {
    return null;
  }

  /**
   * @return DBAdapter
   */
  protected function getDb(): DBAdapter
  {
    return $this->db;
  }
}