<?php declare(strict_types=1);

namespace GAR\Uploader\Readers;

use GAR\Uploader\Readers\ConcreteReader;
use GAR\Uploader\Models\ConcreteTable;
	
class AsHouses extends ConcreteReader 
{
	public static function getElements() : array {
		return ['HOUSE'];
	}

	public static function getAttributes() : array {
		return ['ID', 'OBJECTID', 'OBJECTGUID', 'HOUSENUM', 'HOUSETYPE', 'ISACTUAL', 'ISACTIVE'];
	}

	protected function execDoWork(ConcreteTable $model, array $value) : void
	{
		if ($value['isactive'] === "1" && $value['isactual'] === "1") {
      $value = array_diff_key($value, array_flip(['isactual', 'isactive']));
      $value['id'] = intval($value['id']);
      $value['objectid'] = intval($value['objectid']);
      $value['objectguid'] = intval($value['objectguid']);
      $model->insert($value);
		}
	}
}