<?php declare(strict_types=1);

namespace GAR\Uploader\Readers;

use GAR\Uploader\Readers\ConcreteReader;
use GAR\Uploader\Models\ConcreteTable;
	
class AsAddressObjectParams extends ConcreteReader 
{
	public static function getElements() : array {
		return ['PARAM'];
	}

	public static function getAttributes() : array {
		return ['ID', 'OBJECTID', 'TYPEID', 'VALUE'];
	}

	public function execDoWork(ConcreteTable $model, array $value) : void
	{
    if (in_array($value['typeid'], ['6', '7', '11'])) {
      $model->insert($value);
    }
	}
}