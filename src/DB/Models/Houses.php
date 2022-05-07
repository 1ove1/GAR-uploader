<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Models;

use GAR\Uploader\Models\ConcreteTable;
use JetBrains\PhpStorm\ArrayShape;


/**
 * AS HOUSES CLASS-MODEL
 *
 * EXTENDS CONCRETE TABLE AND USING FOR COMMUNICATE
 * WITH TABLE 'address_info'
 */
class Houses extends ConcreteTable 
{
	#[ArrayShape(['id_houses' => "string[]",
    'objectid_houses' => "string[]",
    'objectguid_houses' => "string[]",
    'housenum_houses' => "string[]",
    'housetype_houses' => "string[]"])]
  public function fieldsToCreate() : ?array
	{
		return [
			'id_houses' => [
        'BIGINT UNSIGNED NOT NULL',
			],
			'objectid_houses' => [
        'BIGINT UNSIGNED NOT NULL',
			],
			'objectguid_houses' => [
        'BIGINT UNSIGNED NOT NULL',
			],
			'housenum_houses' => [
				'CHAR(100) NOT NULL',
			],
			'housetype_houses' => [
				'CHAR(50) NOT NULL',
			],
		];
	}
}