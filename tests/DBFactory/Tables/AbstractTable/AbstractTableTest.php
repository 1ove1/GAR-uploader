<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use TPO\LAB2\DBFactory\Tables\AbstractTable\AbstractTable;
use TPO\LAB2\DBFactory\Tables\AbstractTable\TableItem;
use TPO\LAB2\DBFactory\DBFacade;

final class AbstractTableTest extends TestCase
{
	use AbstractTable;

	private ?string $name = null;
	private ?array 	$fields = null;
	private ?PDO 	$PDO = null;

	public function testGetTableName() : void 
	{
		$input = 'SomeName';
		$output = 'some_name';
		$this->getTableName($input);

		$this->assertEquals($output, $this->name);
	}

	public function testSelect() {
		$this->PDO = DBFacade::getInstance();

		$this->name = 'tests';

		$this->assertEquals(
			$this->PDO->query('SELECT * FROM tests')->fetchAll(\PDO::FETCH_ASSOC), 
			$this->select('*'), 
			'all list');
		$this->assertEquals(
			$this->PDO->query('SELECT id FROM tests')->fetchAll(\PDO::FETCH_ASSOC), 
			$this->select('id'),
			'only id');
		$this->assertEquals(
			$this->PDO->query('SELECT message FROM tests')->fetchAll(\PDO::FETCH_ASSOC), 
			$this->select('message'), 
			'only messages');
		foreach (['<', '<=', '=' , '>', '>='] as $sign) {
			$this->assertEquals(
			$this->PDO->query('SELECT message FROM tests WHERE id' . $sign . '2')->fetchAll(\PDO::FETCH_ASSOC), 
			$this->select('message', $sign, ['id', 2]), 
			'where compare (id ' . $sign . ')');	
		}
	}
}