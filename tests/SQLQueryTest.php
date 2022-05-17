<?php declare(strict_types=1);

namespace GAR\Tests;

use GAR\Uploader\DB\Table\AbstractTable\Container;
use GAR\Uploader\DB\Table\AbstractTable\Container\QueryContainer;
use GAR\Uploader\DB\Table\AbstractTable\Container\QueryObject;
use GAR\Uploader\DB\Table\AbstractTable\Container\QueryTypes;
use PHPUnit\Framework\TestCase;

class SQLQueryTest extends TestCase
{
  private QueryContainer $query;
  private QueryFactory $factory;

  private const SQL = 'SELECT column1, column2 FROM table WHERE column1=value1';
  private const TYPE = QueryTypes::META;

  protected function setUp(): void
  {
    parent::setUp();
    $this->query = (new QueryObject())
      ->setType(self::TYPE)
      ->setRawSql(self::SQL)
      ->validate(function (string $sqlCode) {
        return preg_match(
          '/^SELECT [A-z., \d]+ FROM [A-z., \d]+ WHERE [A-z\d<=>]+$/',
          $sqlCode);
      });
  }

  public function testGetType()
  {
    $this->assertObjectNotHasAttribute('setType()', $this->query);
    $this->assertEquals(QueryTypes::META, $this->query->getType());
  }

  public function testGetRawSql()
  {
    $this->assertObjectNotHasAttribute('setRawSql()', $this->query);
    $this->assertEquals(self::SQL, $this->query->getRawSql());
  }

  public function testIsValid()
  {
    $this->assertObjectNotHasAttribute('validate', $this->query);
    $this->assertEquals(true, $this->query->isValid());
  }
}
