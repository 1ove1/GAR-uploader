<?php declare(strict_types=1);

namespace GAR\Tests;

use GAR\Uploader\DB\Table\AbstractTable\Container;
use GAR\Uploader\DB\Table\AbstractTable\QueryGenerator;
use PHPUnit\Framework\TestCase;

class SQLFactoryTest extends TestCase
{
  private QueryFactory $factory;

  private const TABLE_NAME = 'test';
  private const FIELDS = [['column1'], ['column2'], ['column3']];
  private const FIELDS_PARAM = [
    'column1' => ["param1"], 'column2' => ["param2"], 'column3' => ["param3"]
  ];
  private const WHERE_SIGN = [['<'], ['<='], ['='], ['=>'], ['>']];
  private const WHERE_COND = [['column1' => 'value1'], ['column2' => 'value2']];

  private const SQL_SELECT = [
    'SELECT column1, column2, column3 FROM test',
    'SELECT column2 FROM test WHERE column2=value2',
    'SELECT column3 FROM test WHERE column1=>value1 AND column2=value2',
  ];

  private const SQL_CREATE = [
    'DROP TABLE IF EXISTS test; CREATE TABLE test (column1 param1, column2 param2, column3 param3)',
  ];

  private const SQL_META = [
    'DESCRIBE test',
  ];

  private const SQL_SHOW_TABLE = [
    'SHOW TABLES',
  ];

  private const SQL_DROP_TABLE = [
    'DROP TABLE IF EXISTS test'
  ];

  protected function setUp(): void
  {
    parent::setUp();
    $this->factory = new QueryGenerator();
  }


  public function testGenSelectQuery()
  {
    $qAllSelect = $this->factory->genSelectQuery(
      self::TABLE_NAME,
      array_merge(self::FIELDS[0], self::FIELDS[1], self::FIELDS[2])
    );
    self::assertEquals(
      self::SQL_SELECT[0],
      $qAllSelect->getRawSql()
    );

    $qSelectColl2WhereOneEqual = $this->factory->genSelectQuery(
      self::TABLE_NAME,
      self::FIELDS[1],
      self::WHERE_SIGN[2],
      self::WHERE_COND[1]
    );
    self::assertEquals(self::SQL_SELECT[1], $qSelectColl2WhereOneEqual->getRawSql());

    $qSelectColl3WhereTwoDiffEqual = $this->factory->genSelectQuery(
      self::TABLE_NAME,
      self::FIELDS[2],
      array_merge(self::WHERE_SIGN[3], self::WHERE_SIGN[2]),
      array_merge(self::WHERE_COND[0], self::WHERE_COND[1])
    );
    self::assertEquals($qSelectColl3WhereTwoDiffEqual->getRawSql(), self::SQL_SELECT[2]);
  }

  public function testGenCreateTableQuery()
  {
    $qCreateTable = $this->factory->genCreateTableQuery(self::TABLE_NAME, self::FIELDS_PARAM);
    $this->assertEquals(self::SQL_CREATE[0], $qCreateTable->getRawSql());
  }

  public function testGenMetaQuery()
  {
    $qMetaTable = $this->factory->genMetaQuery(self::TABLE_NAME);
    $this->assertEquals(self::SQL_META[0], $qMetaTable->getRawSql());
  }

  public function testGenShowTableQuery()
  {
    $qShowTable = $this->factory->genShowTableQuery();
    $this->assertEquals(self::SQL_SHOW_TABLE[0], $qShowTable->getRawSql());
  }

  public function testGenDropTableQuery()
  {
    $qDropTable = $this->factory->genDropTableQuery(self::TABLE_NAME);
    $this->assertEquals(self::SQL_DROP_TABLE[0], $qDropTable->getRawSql());
  }


}
