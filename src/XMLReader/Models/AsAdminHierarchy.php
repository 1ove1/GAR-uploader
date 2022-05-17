<?php declare(strict_types=1);

namespace GAR\Uploader\XMLReader\Models;

use GAR\Uploader\DB\Table\AbstractTable\SQL\QueryModel;
use GAR\Uploader\Log;
use GAR\Uploader\XMLReader\Readers\ConcreteReader;

class AsAdminHierarchy extends ConcreteReader
{
	public static function getElements() : array {
		return ['ITEM'];
	}

	public static function getAttributes() : array {
		return ['ID', 'OBJECTID', 'PARENTOBJID'];
	}

	public function execDoWork(QueryModel $model, array $value) : void
	{
//    if (
//      $model->select(['addr.objectid_addr'], ['addr' => 'addr_obj'])
//        ->where('addr.objectid_addr', '=', $value['objectid'])
//        ->save()
//    ) {
//      if (
//        $model->select(['addr.objectid_addr'], ['addr' => 'addr_obj'])
//        ->where('addr.objectid_addr', '=', $value['parentobjid'])
//        ->save()
//        ){
        $model->forceInsert([
          (int)$value['id'],
          (int)$value['objectid'],
          (int)$value['parentobjid'],
        ]);
//      } else {
//        Log::write('not found ' . (int)$value['parentobjid'] . ' in ' . $this->key());
//      }
//    } else {
//      Log::write('not found ' . (int)$value['objectid'] . ' in ' . $this->key());
//    }
	}
}