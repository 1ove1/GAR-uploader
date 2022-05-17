<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Models;

use GAR\Uploader\DB\Table\AbstractTable\SQL\QueryModel;
use GAR\Uploader\DB\Table\ConcreteTable;
use JetBrains\PhpStorm\ArrayShape;


/**
 * ADDRESS INFO CLASS-MODEL
 *
 * EXTENDS CONCRETE TABLE AND USING FOR COMMUNICATE
 * WITH TABLE 'address_info'
 */
class AdminHierarchy extends ConcreteTable implements QueryModel
{
  #[ArrayShape(['id_admin' => "string[]",
    'objectid_admin' => "string[]",
    'parentobjid_admin' => "string[]",
    'FOREIGN KEY (objectid_admin)' => "string[]",
    'FOREIGN KEY (parentobjid_admin)' => "string[]"])]
  public function fieldsToCreate() : ?array
	{
		return [
			'id_admin' => [
        'BIGINT UNSIGNED NOT NULL',
			],
			'objectid_admin' => [
        'BIGINT UNSIGNED NOT NULL',
			],
			'parentobjid_admin' => [
        'BIGINT UNSIGNED NOT NULL',
			],
//      'FOREIGN KEY (objectid_admin)' => [
//        'REFERENCES addr_obj (objectid_addr)'
//      ],
		];
	}
}