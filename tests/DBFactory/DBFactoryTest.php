<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use GAR\Uploader\DBFactory\{
	DBFactory,
	DBFacade,
	Tables\AddressInfo
};

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