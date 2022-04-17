<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use GAR\Uploader\DBFactory\Tables\AbstractTable\{
	MetaTable,
	Queries
};
use GAR\Uploader\DBFactory\DBFacade;

final class MetaTableTest extends TestCase
{
	use Queries, MetaTable;

	const currTable = 'tests';

	private ?PDO 	$PDO = null;
	private ?string $name = self::currTable;
	private ?array 	$fields = null;
	private ?array  $metaInfo = null;
	private ?\PDOStatement $PDOInsert = null;

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
		$this->PDO = DBFacade::getInstance();
		$clearQuery = $this->PDO->query('DESCRIBE ' . self::currTable)->
						fetchAll(\PDO::FETCH_COLUMN);

		$this->assertEquals(
			$clearQuery,
			$this->getMetaInfo(self::currTable)['fields'],
			'test with fileds ' . implode(',', $clearQuery)
		);
	}
}