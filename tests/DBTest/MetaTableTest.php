<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Table\SQL;

use GAR\Uploader\DB\DBFacade;
use GAR\Tests\TestEnv;
use GAR\Uploader\DB\PDOAdapter\PDOElem;
use PHPUnit\Framework\TestCase;

/**
 * TEST METATABLE TEST
 */
class MetaTableTest extends TestCase
{
  private PDOElem $connection;
  private MetaTable $metaTable;

  protected function setUp() : void
  {
    parent::setUp();
    $this->connection = DBFacade::getInstance(TestEnv::class);
    $this->connection->query('BEGIN');
    $this->metaTable = new MetaTable($this->connection);
  }

  protected function tearDown() : void
  {
    parent::tearDown();
    $this->connection->query('ROLLBACK');
  }


}
