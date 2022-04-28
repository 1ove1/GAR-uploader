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
class AddrObjParams extends ConcreteTable 
{
	#[ArrayShape(['id_addr_params' => "string[]", 'objectid_addr_params' => "string[]", 'TYPE' => "string[]", 'VALUE' => "string[]"])] public function setFieldsToCreate() : array
	{
		return [
			'id_addr_params' => [
				'CHAR(50)',
			],
			'objectid_addr_params' => [
				'CHAR(50)',
			],
			'TYPE' => [
				'CHAR(5)',
			],
			'VALUE' => [
				'CHAR(30)',
			],
		];
	}
}