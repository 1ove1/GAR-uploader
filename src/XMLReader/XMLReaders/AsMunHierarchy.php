<?php declare(strict_types=1);

namespace GAR\Uploader\Readers;

use GAR\Uploader\Readers\ConcreteReader;
use GAR\Uploader\Models\ConcreteTable;
	
class AsMunHierarchy extends ConcreteReader
{
	public static function getElements() : array {
		return ['ITEM'];
	}

	public static function getAttributes() : array {
		return ['ID', 'OBJECTID', 'PARENTOBJID', 'OKTMO'];
	}

	public function execDoWork(ConcreteTable $model, array $value) : void
	{
    $value['id'] = intval($value['id']);
    $value['objectid'] = intval($value['objectid']);
    $value['parentobjid'] = intval($value['parentobjid']);
    $value['oktmo'] = intval($value['oktmo']);
		$model->insert($value);
	}
}