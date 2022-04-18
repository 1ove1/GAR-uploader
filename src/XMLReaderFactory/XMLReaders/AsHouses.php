<?php declare(strict_types=1);

namespace GAR\Uploader\XMLReaderFactory\XMLReaders;

use GAR\Uploader\XMLReaderFactory\XMLReaders\ConcreteReader;
use GAR\Uploader\DBFactory\Tables\ConcreteTable;
	
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
			$model->insert(array_diff_key($value, array_flip(['isactual', 'isactive'])));
		}
	}
}