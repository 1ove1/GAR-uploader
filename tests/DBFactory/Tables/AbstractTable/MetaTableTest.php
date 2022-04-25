<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use GAR\Uploader\Models\AbstractTable\MetaTable;
use GAR\Uploader\DBFactory\DBFacade;
use GAR\Tests\TestEnv;

final class MetaTableTest extends TestCase
{
	use MetaTable;

	const currTable = 'tests';

	private ?\PDO 	$PDO = null;

	protected function setUp() : void
	{
		$this->PDO = DBFacade::getInstance(TestEnv::class);
		$this->PDO->exec(
			sprintf(
				'CREATE TABLE IF NOT EXISTS %s(id INTEGER auto_increment PRIMARY KEY, message INTEGER);',
				self::currTable,
		));	

		$this->PDO->exec('BEGIN');
	}	

	protected function tearDown() : void
	{
		$this->PDO->exec('ROLLBACK');
	}

	/**
	 *  simple compare
	 * @return void
	 */
	public function testGetTableName() : void 
	{
		$input = 'SomeName';
		$output = 'some_name';

		$this->assertEquals($output, $this->getTableName($input	));
	}

	/**
	 *  meta info
	 * @return 
	 */
	public function testMetaInfo() {
		$clearQuery = $this->PDO->query('DESCRIBE ' . self::currTable)->
						fetchAll(\PDO::FETCH_COLUMN);

		$this->assertEquals(
			$clearQuery,
			$this->getMetaInfo(self::currTable)['fields'],
			'test with fileds ' . implode(',', $clearQuery)
		);
	}
}