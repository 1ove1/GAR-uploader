<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use GAR\Uploader\DBFactory\Tables\AbstractTable\{
	MetaTable,
	Queries
};
use GAR\Uploader\DBFactory\DBFacade;
use GAR\Tests\TestEnv;

final class MetaTableTest extends TestCase
{
	use MetaTable;

	const currTable = 'tests';

	private ?PDO 	$PDO = null;

	protected function setUp() : void
	{
		$this->PDO = DBFacade::getInstance(TestEnv::class);
		$this->PDO->exec(
			sprintf(
				"DROP TABLE IF EXISTS %s;" . 
				"CREATE TABLE %s(id INTEGER auto_increment PRIMARY KEY, message CHAR(50));",
				self::currTable,
				self::currTable
		));	
	}	

	protected function tearDown() : void
	{
		$this->PDO->exec('DROP TABLE ' . self::currTable);
	}

	// /**
	//  *  simple compare
	//  * @return void
	//  */
	// public function testGetTableName() : void 
	// {
	// 	$input = 'SomeName';
	// 	$output = 'some_name';

	// 	$this->assertEquals($output, $this->getTableName($input	));
	// }

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