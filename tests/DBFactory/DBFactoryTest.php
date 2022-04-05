<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use LAB2\DBFactory\DBFactory;
use LAB2\DBFactory\DBFacade;
use LAB2\DBFactory\Tables\AddressInfo;

final class DBFactoryTest extends TestCase
{
	/**
	 *  checking the return objects
	 * @return void
	 */
	public function testSameObjectsReturned()
	{
		$address_info = new AddressInfo(DBFacade::getInstance());

		$this->assertEquals($address_info, DBFactory::getAddressInfoTable());
	} 
}