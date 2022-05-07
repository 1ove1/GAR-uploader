<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Models;

use GAR\Uploader\Models\ConcreteTable;
use JetBrains\PhpStorm\ArrayShape;


/**
 * ADDRESS INFO CLASS-MODEL
 *
 * EXTENDS CONCRETE TABLE AND USING FOR COMMUNICATE
 * WITH TABLE 'address_info'
 */
class AddrObj extends ConcreteTable 
{
  #[ArrayShape(['id_addr' => "string[]",
    'objectid_addr' => "string[]",
    'objectguid_addr' => "string[]",
    'name_addr' => "string[]",
    'typename_addr' => "string[]"])]
  public function fieldsToCreate() : ?array
	{
		return [
			'id_addr' => [
				'BIGINT UNSIGNED NOT NULL',
			],
			'objectid_addr' => [
				'BIGINT UNSIGNED NOT NULL',
			],
			'objectguid_addr' => [
				'BIGINT UNSIGNED NOT NULL',
			],
			'name_addr' => [
				'VARCHAR(100) NOT NULL',
			],
			'typename_addr' => [
				'VARCHAR(100) NOT NULL',
			],
		];
	}
}