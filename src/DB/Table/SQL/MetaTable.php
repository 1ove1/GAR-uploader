<?php

namespace GAR\Uploader\DB\Table\SQL;

use GAR\Uploader\DB\PDOAdapter\PDOElem;
use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use PDO;

class MetaTable implements Meta
{
  /**
   * @var PDOElem - PDO object
   */
  private readonly PDOElem $db;

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
   * @param PDOElem $db
   * @param string $tableName
   */
  public function __construct(PDOElem $db, string $tableName)
  {
    $this->db = $db;
    $this->name = $this->genTableNameByClassName($tableName);
    if ($this->setFieldsToCreate() !== null) {
      $this->createTable();
    }

    [$this->metaInfo, $this->fields] = $this->getMetaInfoAndFields($this->getName());
  }

  /**
   * Convert classname to normal table name
   * @param string $className - camel case classname
   * @return string
   */
  private function genTableNameByClassName(string $className) : string
  {
    // remove some ..\\..\\..\\ClassName prefix
    $arrStr = explode('\\', $className);
    $className = end($arrStr);

    $tableName = '';
    foreach (str_split(strtolower($className)) as $key => $char) {
      if ($key !== 0 && ctype_upper($className[$key])) {
        $tableName .= '_';
      }
      $tableName .= $char;
    }

    if (!preg_match('/^[a-zA-Z][a-zA-Z_]{1,18}$/',$tableName)) {
      throw new InvalidArgumentException('invalid table name :' . $tableName);
    }

    return $tableName;
  }

  /**
   *  getting meta info from table meta (only for mysql)
   * @param string $tableName name of table (probably $this->name)
   * @return array
   */
  #[ArrayShape(['metaInfo' => "array|false", 'fields' => "array|false"])]
  private function getMetaInfoAndFields(string $tableName) : array
  {
    $query = 'DESCRIBE ' . $tableName;

    $metaInfo = $this->getDb()->query($query)->fetchAll(PDO::FETCH_ASSOC);
    $tableFields = $this->getDb()->query($query)->fetchAll(PDO::FETCH_COLUMN);

    return [$metaInfo, $tableFields];
  }

  /**
   * Create table using curr connected, name of table and fields
   * @return void
   */
  private function createTable() : void
  {
    if (!$this->tableExistsAndDropCheck($this->getName())) {
      return;
    }

    $formattedFields = [];

    foreach ($this->setFieldsToCreate() as $field => $params) {
      if (empty($params)) {
        throw new InvalidArgumentException(sprintf(
          "field %s should contains type params!",
          $field
        ));
      }
      $formattedFields[] = sprintf(
        "%s %s",
        $field,
        implode(' ', $params)
      );
    }

    $createQuery = sprintf(
      'DROP TABLE IF EXISTS %1$s; CREATE TABLE %1$s (%2$s)',
      $this->getName(),
      implode(', ', $formattedFields)
    );

    $this->getDb()->query($createQuery);
  }

  /**
   * Check table existing and ask user to drop it if exist
   * @param string $tableName - name of table
   * @return bool - user decision
   */
  private function tableExistsAndDropCheck(string $tableName) : bool
  {
    $connection = $this->getDb();
    $tableList = $connection->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    $userInput = '';

    if (in_array($tableName, $tableList)) {
      trigger_error('MetaTable warning: table ' . $tableName . ' already exists');
      do {
        $userInput = readline(
          'create new ' . $tableName . '? [Y/n]: '
        );
      } while (!preg_match('/[YyNnДдНн]+/', $userInput));
    }
    return !preg_match("/[NnНн]/", $userInput);
  }

  /**
   * @return string
   */
  protected function getName(): string
  {
    return $this->name;
  }

  /**
   * @return array
   */
  protected function getMetaInfo(): mixed
  {
    return $this->metaInfo;
  }

  /**
   * @return array|null - curr fields
   */
  function getFields(): ?array
  {
    return $this->fields;
  }

  /**
   * @return array|null - fields to create (null if not)
   */
  function setFieldsToCreate(): ?array
  {
    return null;
  }

  /**
   * @return PDOElem
   */
  protected function getDb(): PDOElem
  {
    return $this->db;
  }
}