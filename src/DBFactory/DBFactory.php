<?php declare(strict_types=1);

namespace LAB2\DBFactory;

use LAB2\DBFactory\DBFacade;
use LAB2\DBFactory\Tables\AddressInfo;

/**
 * BDFACTORY CLASS
 *
 * FULL-STATIC FABRIC
 * RETURN COMPLETED MODELS
 */
final class DBFactory 
{
	/**
	 * return address info table
	 * @return void
	 */
	public static function getAddressInfoTable()
	{
		return new AddressInfo(DBFacade::getInstance());
	}
}