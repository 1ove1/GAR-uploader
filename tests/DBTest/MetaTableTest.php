<?php declare(strict_types=1);

namespace GAR\Tests\DBTest;

use GAR\Tests\TestEnv;
use GAR\Uploader\DB\DBFacade;
use GAR\Uploader\DB\PDOAdapter\PDOObject;
use GAR\Uploader\DB\Table\AbstractTable\MetaTable;
use PHPUnit\Framework\TestCase;

/**
 * TEST METATABLE TEST
 */
class MetaTableTest extends TestCase
{
  private const TEST_TABLE = 'test';
  private PDOObject $connection;
  private MetaTable $metaTable;

  protected function setUp() : void
  {
    parent::setUp();
    $this->connection = DBFacade::getInstance(TestEnv::class);
//    $this->connection->query('BEGIN');
    $this->metaTable = new MetaTable($this->connection, self::TEST_TABLE);
  }

  protected function tearDown() : void
  {
    parent::tearDown();
//    $this->connection->query('ROLLBACK');
  }

  public function testName()
  {

  }


}
