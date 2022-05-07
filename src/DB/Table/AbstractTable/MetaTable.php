<?php

namespace GAR\Uploader\DB\Table\AbstractTable;

use GAR\Uploader\DB\PDOAdapter\DBAdapter;
use GAR\Uploader\DB\PDOAdapter\PDOObject;
use GAR\Uploader\DB\Table\AbstractTable\SQLFactory\SQLGenerator;
use JetBrains\PhpStorm\ArrayShape;

class MetaTable
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
   * Create meta table object
   * @param DBAdapter $db - database adapter connection
   * @param string $tableName - name of table
   * @param ?array $createOption - option for create table
   */
  public function __construct(DBAdapter $db,
                              string $tableName,
                              ?array $createOption)
  {
    $this->db = $db;
    $this->name = $tableName;
    if ($createOption !== null) {
      $this->createTable($tableName, $createOption);
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

    $metaInfo = $this->getDb()->rawQuery($query)->fetchAll(PDOObject::F_ALL);
    $tableFields = $this->getDb()->rawQuery($query)->fetchAll(PDOObject::F_COL);

    return [$metaInfo, $tableFields];
  }

  /**
   * Create table using curr connected, name of table and fields
   * @param string $tableName - name of table
   * @param array $createOption - fields and their params
   * @return void
   */
  private function createTable(string $tableName, array $createOption) : void
  {
    if (!$this->tableExistsAndDropCheck($tableName)) {
      return;
    }

    $this->getDb()->rawQuery(SQLGenerator::genCreateTableQuery(
      $this->getName(), $createOption
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
                            ->fetchAll(PDOObject::F_COL);
    $userInput = 'Y';

    if (in_array($tableName, $tableList)) {
      do {
        $userInput = readline(
          'create new ' . $tableName . '? [Y/n]: '
        );
      } while (!preg_match('/[YyNnДдНн]+/', $userInput));
    }
    return preg_match("/[YyДд]/", $userInput);
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
   * @return DBAdapter
   */
  protected function getDb(): DBAdapter
  {
    return $this->db;
  }
}