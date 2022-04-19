<?php declare(strict_types=1);

namespace GAR\Uploader\DBFactory;

use GAR\Uploader\DBFactory\DBFacade;
use GAR\Uploader\Models\{
		ConcreteTable,
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
	
	public static function getAddressInfoTable() : ConcreteTable
	{
		return new AddressInfo(DBFacade::getInstance());
	}

	public static function getHousesTable() : ConcreteTable
	{
		return new Houses(DBFacade::getInstance());
	}
}
