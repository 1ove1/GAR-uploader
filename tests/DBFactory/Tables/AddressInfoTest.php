<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use LAB2\DBFactory\Tables\AddressInfo;
use LAB2\DBFactory\Tables\AbstractTable\AbstractTable;
use LAB2\DBFactory\DBFacade;

final class AddressInfoTest extends TestCase
{

	use AbstractTable;

	const currTable = 'address_info';

	private ?PDO 	$PDO = null;
	private ?string $name = self::currTable;
	private ?array 	$fields = null;
	private ?array  $metaInfo = null;
	private ?\PDOStatement $PDOInsert = null;

	/**
	 *  select test (full, id, message, where)
	 * @return void
	 */
	public function testSelect() : void 
	{
		$this->PDO = DBFacade::getInstance();

		$table = new AddressInfo(DBFacade::getInstance());

		$query = 'SELECT * FROM ' . self::currTable;

		$this->assertEquals(
			$this->PDO->query($query)
					  ->fetchAll(\PDO::FETCH_ASSOC), 
			$table->select('*'), 
			$query
		);

		foreach ($this->getMetaInfo(self::currTable)['fields'] as $field) {
			$query = 'SELECT ' . $field. ' FROM ' . self::currTable;

			$this->assertEquals(
				$this->PDO->query($query)->fetchAll(\PDO::FETCH_ASSOC), 
				$table->select($field),
				$query
			);	

			foreach (['<', '<=', '=' , '>', '>='] as $sign) {
				$query = 'SELECT * FROM ' . self::currTable . ' WHERE ' . $field . $sign . '2';

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
		$this->PDO = DBFacade::getInstance();
		$this->metaInfo = $this->getMetaInfo(self::currTable)['meta'];
		$this->prepareInsertPDOStatement();

		$table = new AddressInfo(DBFacade::getInstance());

		for ($iter = 5; $iter > 0; --$iter) {
			$rnd = rand();
			$select = 'SELECT message FROM ' . self::currTable . ' WHERE message=' . $rnd;

			$this->insert(['message' => $rnd]);

			$this->assertEquals(
				$this->PDO->query($select)->fetchAll(\PDO::FETCH_ASSOC)[0]['message'],
				$rnd,
				'test insert query with ' . $rnd
			);
		}
	} 
}