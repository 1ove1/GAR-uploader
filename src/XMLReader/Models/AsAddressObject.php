<?php declare(strict_types=1);

namespace GAR\Uploader\XMLReader\Models;

use GAR\Uploader\DB\Table\AbstractTable\SQL\QueryModel;
use GAR\Uploader\XMLReader\Readers\ConcreteReader;

class AsAddressObject extends ConcreteReader 
{
	public static function getElements() : array {
		return ['OBJECT'];
	}

	public static function getAttributes() : array {
		return ['ID', 'OBJECTID', 'OBJECTGUID', 'NAME', 'TYPENAME', 'LEVEL', 'ISACTUAL', 'ISACTIVE'];
	}

	public function execDoWork(QueryModel $model, array $value) : void
	{
		if ($value['isactive'] === "1" && $value['isactual'] === "1") {
			$model->forceInsert([
        (int)$value['id'],
        (int)$value['objectid'],
        $value['objectguid'],
        (int)$value['level'],
        $value['name'],
        $value['typename'],
      ]);
		}
	}
}