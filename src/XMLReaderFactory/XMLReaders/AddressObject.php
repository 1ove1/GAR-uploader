<?php declare(strict_types=1);

namespace LAB2\XMLReaderFactory\XMLReaders;

use LAB2\XMLReaderFactory\XMLReaders\ConcreteReader;
use LAB2\DBFactory\Tables\ConcreteTable;
	
class AddressObject extends ConcreteReader 
{
	public static function getElements() : array {
		return ['OBJECT'];
	}

	public static function getAttributes() : array {
		return ['ID', 'OBJECTID', 'OBJECTGUID', 'NAME', 'TYPENAME', 'ISACTUAL', 'ISACTIVE'];
	}

	public function excecDoWork(ConcreteTable $model, array $value) : void
	{
		if ($value['isactive'] === "1" && $value['isactual'] === "1") {
			$model->insert(array_diff_key($value, array_flip(['isactual', 'isactive'])));
		}
	}
}