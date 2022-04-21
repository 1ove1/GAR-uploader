<?php declare(strict_types=1);

namespace GAR\Uploader\Readers;

use GAR\Uploader\Readers\ConcreteReader;
use GAR\Uploader\Models\ConcreteTable;
	
class AsAdminHierarchi extends ConcreteReader 
{
	public static function getElements() : array {
		return ['ITEM'];
	}

	public static function getAttributes() : array {
		return ['ID', 'OBJECTID', 'PARENTOBJID'];
	}

	public function execDoWork(ConcreteTable $model, array $value) : void
	{
		$model->insert($value);
	}
}