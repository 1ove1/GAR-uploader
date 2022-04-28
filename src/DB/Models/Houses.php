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
	#[ArrayShape(['id_houses' => "string[]", 'objectid_houses' => "string[]", 'objectguid_houses' => "string[]", 'housenum_houses' => "string[]", 'housetype_houses' => "string[]"])] public function setFieldsToCreate() : array
	{
		return [
			'id_houses' => [
				'CHAR(50)',
			],
			'objectid_houses' => [
				'CHAR(50)',
			],
			'objectguid_houses' => [
				'CHAR(50)',
			],
			'housenum_houses' => [
				'CHAR(100)',
			],
			'housetype_houses' => [
				'CHAR(50)',
			],
		];
	}
}