<?php declare(strict_types=1);

namespace GAR\Uploader\DBFactory;

use GAR\Uploader\DBFactory\DBFacade;
use GAR\Uploader\Models\{
		ConcreteTable,
	  AddrObj,
	 	AddrObjParams,
    Houses,
		AdminHierarchy,
		MunHierarchy,
};

/**
 * BDFACTORY CLASS
 *
 * FULL-STATIC FABRIC
 * RETURN COMPLETED MODELS
 */
final class DBFactory 
{
	
	public static function getAddressObjectTable() : ConcreteTable
	{
		 return new AddrObj(DBFacade::getInstance());
	}

	public static function getAddressObjectParamsTable() : ConcreteTable
	{
			return new AddrObjParams(DBFacade::getInstance());
	}

	public static function getHousesTable() : ConcreteTable
	{
		return new Houses(DBFacade::getInstance());
	}

	public static function getAdminTable() : ConcreteTable
	{
		return new AdminHierarchy(DBFacade::getInstance());
	}

	public static function getMunTable() : ConcreteTable
	{
		return new MunHierarchy(DBFacade::getInstance());
	}
}
