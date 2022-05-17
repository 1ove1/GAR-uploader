<?php declare(strict_types=1);

namespace GAR\Tests;

use GAR\Uploader\DB\{DBFacade,
  PDOAdapter\DBAdapter,
  PDOAdapter\PDOObject,
  Table\AbstractTable\QueryGenerator,
  Table\Query};
use PHPUnit\Framework\TestCase;

class TableConceptTest extends TestCase
{
  private DBAdapter $pdo;
  private Query $table;

  private const TABLE_NAME = 'test';
  private const INSERT_1 = ['id' => 1, 'message' => 'value1'];
  private const INSERT_2 = ['id' => 2, 'message' => 'value2'];
  private const INSERT_3 = ['id' => 3, 'message' => 'value3'];

  protected function setUp(): void
  {
    $this->pdo = DBFacade::getInstance(TestEnv::class);
    $this->pdo->rawQuery(QueryGenerator::genDropTableQuery(self::TABLE_NAME));
    $this->table = new Test($this->pdo);
  }

  protected function tearDown() : void
  {
    parent::tearDown();
    $this->pdo->rawQuery(QueryGenerator::genDropTableQuery(self::TABLE_NAME));
  }

  public function testGetName()
  {
    $this->assertEquals(
      self::TABLE_NAME,
      $this->table->getName()
    );
  }


  public function testInsert()
  {
    foreach ([self::INSERT_1, self::INSERT_2, self::INSERT_3] as $q) {
      $this->table->insert($q)->save();
    }

    $this->assertEquals(
      [self::INSERT_1, self::INSERT_2, self::INSERT_3],
      $this->pdo->rawQuery(QueryGenerator::genSelectQuery(self::TABLE_NAME, ['*']))->fetchAll()
    );
  }

  public function testSave()
  {
    $iter = (int)TestEnv::sqlInsertBuffer->value + 1;
    while($iter > 0) {
      foreach ([self::INSERT_1, self::INSERT_2, self::INSERT_3] as $q) {
        $this->table->insert($q);
      }
      $iter -= 3;
    }

    $this->assertCount(
      (int)TestEnv::sqlInsertBuffer->value,
      $this->pdo->rawQuery(
        QueryGenerator::genSelectQuery(self::TABLE_NAME, ['*']))->fetchAll()
    );
  }

  public function testSelect()
  {
    foreach ([self::INSERT_1, self::INSERT_2, self::INSERT_3] as $q) {
      $this->table->insert($q)->save();
    }

    $this->assertEquals(
      self::INSERT_2,
      $this->pdo->rawQuery(
        QueryGenerator::genSelectQuery(self::TABLE_NAME, ['*'], ['='], ['id' => '2']))->fetchAll()[0]
    );
  }

  public function testFieldsToCreate()
  {
    $this->pdo->rawQuery(QueryGenerator::genMetaQuery(self::TABLE_NAME));
    $result = $this->pdo->fetchAll(PDOObject::F_COL);
    self::assertEquals(
      array_keys($this->table->fieldsToCreate()),
      $result
    );
  }

  public function testFetchAll()
  {
    foreach ([self::INSERT_1, self::INSERT_2, self::INSERT_3] as $q) {
      $this->table->insert($q)->save();
    }

    $this->assertEquals(
      [self::INSERT_1, self::INSERT_2, self::INSERT_3],
      $this->table->select(array_keys($this->table->fieldsToCreate()))->fetchAll()
    );
  }


}
