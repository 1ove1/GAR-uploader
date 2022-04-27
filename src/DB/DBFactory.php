<?php declare(strict_types=1);

namespace GAR\Uploader\DB;

use GAR\Uploader\DB\Models\AddrObj;
use GAR\Uploader\DB\Models\AddrObjParams;
use GAR\Uploader\DB\Models\AdminHierarchy;
use GAR\Uploader\DB\Models\Houses;
use GAR\Uploader\DB\Models\MunHierarchy;
use GAR\Uploader\Models\{ConcreteTable,};

/**
 * BD FACTORY CLASS
 *
 * FULL-STATIC FABRIC
 * RETURN COMPLETED MODELS
 */
class DBFactory
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
