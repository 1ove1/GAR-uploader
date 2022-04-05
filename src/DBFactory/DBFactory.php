<?php declare(strict_types=1);

namespace LAB2\DBFactory;

use LAB2\DBFactory\DBFacade;
use LAB2\DBFactory\Tables\AddressInfo;

final class DBFactory 
{
	public static function getAddressInfoTable()
	{
		return new AddressInfo(DBFacade::getInstance());
	}
}