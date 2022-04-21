<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use GAR\Uploader\Readers\AddressObject;

use GAR\Uploader\DBFactory\DBFactory;

class AddressObjectTest extends TestCase
{
	public function testBasicPutput() {
		$nameDefault = '01/AS_ADDR_OBJ';
		$name = [
			'02/AS_ADDR_OBJ', '03/AS_ADDR_OBJ', 
			'04/AS_ADDR_OBJ', '05/AS_ADDR_OBJ', 
			'06/AS_ADDR_OBJ',
		];

		
		$addr_info = DBFactory::getAddressInfoTable();

		$addrObject = new AddressObject($nameDefault);

		foreach ($name as $value) {
			$addrObject->linked(new AddressObject($value));
		}


		$addrObject->excec($addr_info);
	}
}