<?php declare(strict_types=1);

namespace GAR\Uploader\DBFactory;

use GAR\Uploader\DBFactory\DBFacade;
use GAR\Uploader\DBFactory\Tables\{
	AddressInfo,
	Houses
};

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

	public static function getHousesTable()
	{
		return new Houses(DBFacade::getInstance());
	}
}