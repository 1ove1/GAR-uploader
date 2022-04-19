<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use GAR\Uploader\Models\AbstractTable\{
	Queries, MetaTable, AbstractTable
};
use GAR\Uploader\Models\ConcreteTable;
use GAR\Uploader\DBFactory\DBFacade;
use GAR\Tests\TestEnv;

class Tests extends ConcreteTable
{

}

final class AbstractTableTest extends TestCase
{
	use Queries, MetaTable;

	const currTable = 'tests';
	const insertField = 'message';

	private ?PDO 	$PDO = null;
	private ?string $name = self::currTable;
	private ?array 	$fields = null;
	private ?array  $metaInfo = null;
	private ?\PDOStatement $PDOInsert = null;

	protected function setUp() : void
	{
		$this->PDO = DBFacade::getInstance(TestEnv::class);		
		$this->PDO->exec(
			sprintf(
				'CREATE TABLE IF NOT EXISTS %s(id INTEGER auto_increment PRIMARY KEY, message INTEGER);',
				self::currTable,
		));	

		$this->fields = $this->getMetaInfo(self::currTable)['fields'];
		$this->metaInfo = $this->getMetaInfo(self::currTable)['meta'];

		$this->prepareInsertPDOStatement(1);

		$this->PDO->exec('BEGIN');
	}

	protected function tearDown() : void
	{
		$this->PDO->exec('ROLLBACK');
	}

	/**
	 *  select test (full, id, message, where)
	 * @return void
	 */
	public function testSelect() : void 
	{
		$table = new Tests(DBFacade::getInstance());

		$query = 'SELECT * FROM ' . self::currTable;

		$this->assertEquals(
			$this->PDO->query($query)->fetchAll(\PDO::FETCH_ASSOC), 
			$table->select('*'), 
			$query
		);

		foreach ($this->fields as $field) {

			$query = sprintf('SELECT %1$s FROM %2$s',
				$field, 
				self::currTable,
			);

			$this->assertEquals(
				$this->PDO->query($query)->fetchAll(\PDO::FETCH_ASSOC), 
				$table->select($field),
				$query
			);	

			foreach (['<', '<=', '=' , '>', '>='] as $sign) {

				$query = sprintf('SELECT * FROM %s WHERE %s%s2',
					self::currTable,
					$field,
					$sign,
				);

				$this->assertEquals(
					$this->PDO->query($query)->fetchAll(\PDO::FETCH_ASSOC), 
					$table->select('*', $sign, [$field, 2]), 
					$query
				);
			}
		}
	}

	/**
	 * insert test (5 times with random values)	
	 * @return void
	 */
	public function testInsert() : void
	{

		$table = new Tests(DBFacade::getInstance());

		for ($iter = 5; $iter > 0; --$iter) {
			$rnd = rand();
			$select = sprintf(
				'SELECT %1$s FROM %2$s WHERE %1$s=%3$s',
				self::insertField,
				self::currTable,
				$rnd,
			);

			$table->insert([self::insertField => $rnd]);
			$table->save();


			$this->assertEquals(
				$this->PDO->query($select)->fetchAll(\PDO::FETCH_ASSOC)[0][self::insertField],
				$rnd,
				'test insert query with ' . $rnd
			);
		}
	} 
}