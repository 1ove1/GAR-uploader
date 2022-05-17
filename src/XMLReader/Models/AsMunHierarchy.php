<?php declare(strict_types=1);

namespace GAR\Uploader\XMLReader\Models;

use GAR\Uploader\DB\Table\AbstractTable\SQL\QueryModel;
use GAR\Uploader\XMLReader\Readers\ConcreteReader;

class AsMunHierarchy extends ConcreteReader
{
	public static function getElements() : array {
		return ['ITEM'];
	}

	public static function getAttributes() : array {
		return ['ID', 'OBJECTID', 'PARENTOBJID', 'OKTMO'];
	}

	public function execDoWork(QueryModel $model, array $value) : void
	{
    $value['id'] = intval($value['id']);
    $value['objectid'] = intval($value['objectid']);
    $value['parentobjid'] = intval($value['parentobjid']);
    $value['oktmo'] = intval($value['oktmo']);
		$model->forceInsert($value);
	}
}