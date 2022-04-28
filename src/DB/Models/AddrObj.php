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
  #[ArrayShape(['id_addr' => "string[]", 'objectid_addr' => "string[]", 'objectguid_addr' => "string[]", 'name_addr' => "string[]", 'typename_addr' => "string[]"])] public function setFieldsToCreate() : array
	{
		return [
			'id_addr' => [
				'CHAR(50)',
			],
			'objectid_addr' => [
				'CHAR(50)',
			],
			'objectguid_addr' => [
				'CHAR(50)',
			],
			'name_addr' => [
				'CHAR(100)',
			],
			'typename_addr' => [
				'CHAR(50)',
			],
		];
	}
}