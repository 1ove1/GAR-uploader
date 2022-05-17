<?php declare(strict_types=1);

namespace GAR\Uploader\DB;

use GAR\Uploader\DB\Models\{AddrObj, AddrObjParams, AdminHierarchy, Houses, MunHierarchy, ObjLevels};
use GAR\Uploader\DB\Table\AbstractTable\SQL\QueryModel;

/**
 * BD FACTORY CLASS
 *
 * FULL-STATIC FABRIC
 * RETURN COMPLETED MODELS
 */
class DBFactory
{
	
	public static function getAddressObjectTable() : QueryModel
	{
		 return new AddrObj(DBFacade::getInstance());
	}

	public static function getAddressObjectParamsTable() : QueryModel
	{
			return new AddrObjParams(DBFacade::getInstance());
	}

	public static function getHousesTable() : QueryModel
	{
		return new Houses(DBFacade::getInstance());
	}

	public static function getAdminTable() : QueryModel
	{
		return new AdminHierarchy(DBFacade::getInstance());
	}

	public static function getMunTable() : QueryModel
	{
		return new MunHierarchy(DBFacade::getInstance());
	}

  public static function getObjectLevels() : QueryModel
  {
    return new ObjLevels(DBFacade::getInstance());
  }
}