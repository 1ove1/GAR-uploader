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
class MunHierarchy extends ConcreteTable implements QueryModel
{
	#[ArrayShape(['id_mun' => "string[]",
    'objectid_mun' => "string[]",
    'parentobjid_mun' => "string[]",
    'oktmo_mun' => "string[]"])]
  public function fieldsToCreate() : ?array
	{
		return [
			'id_mun' => [
        'BIGINT UNSIGNED NOT NULL',
			],
			'objectid_mun' => [
        'BIGINT UNSIGNED NOT NULL',
			],
			'parentobjid_mun' => [
        'BIGINT UNSIGNED NOT NULL',
			],
      'oktmo_mun' => [
        'BIGINT UNSIGNED NOT NULL',
			],
		];
	}
}