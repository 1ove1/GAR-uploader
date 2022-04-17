<?php declare(strict_types=1);

namespace LAB2\XMLReaderFactory\XMLReaders;

use LAB2\XMLReaderFactory\XMLReaders\ConcreteReader;
use LAB2\DBFactory\Tables\ConcreteTable;
	
class AsHouses extends ConcreteReader 
{
	public static function getElements() : array {
		return ['HOUSE'];
	}

	public static function getAttributes() : array {
		return ['ID', 'OBJECTID', 'OBJECTGUID', 'HOUSENUM', 'HOUSETYPE', 'ISACTUAL', 'ISACTIVE'];
	}

	public function excec(ConcreteTable $model) : void
	{
		foreach ($this as $value) {
			if ($value['isactive'] === "1" && $value['isactual'] === "1") {
				$model->insert(array_diff_key($value, array_flip(['isactual', 'isactive'])));
			}
		}
		if (!is_null($this->linkToAnother)) {
			$this->__destruct();
			$this->linkToAnother->excec($model);
		}
	}
}