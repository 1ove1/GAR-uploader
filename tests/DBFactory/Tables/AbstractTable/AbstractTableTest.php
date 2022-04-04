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
	private ?PDO 	$connect = null;

	public function testGetTableName() : void 
	{
		$input = 'SomeName';
		$output = 'some_name';
		$this->getTableName($input);

		$this->assertEquals($output, $this->name);
	}

	public function testSelect() {
		$result = [0 => ['id' => 1, 'message' => "test message for test case"]];

		$this->name = 'tests';

		$this->assertEquals($this->select('*'), $result);
	}
}