<?php declare(strict_types=1);

namespace GAR\Uploader\Models;

use GAR\Uploader\Models\ConcreteTable;


/**
 * ADDRESS INFO CLASS-MODEL
 *
 * EXTENDS CONCRETE TABLE AND USING FOR COMMUNICATE
 * WITH TABLE 'address_info'
 */
class AddrObjParams extends ConcreteTable 
{
	public function getFieldsToCreate() : array 
	{
		return [
			'id_addr_params' => [
				'CHAR(50)',
			],
			'objectid_addr_params' => [
				'CHAR(50)',
			],
			'TYPE' => [
				'INTEGER',
			],
			'VALUE' => [
				'CHAR(100)',
			],
		];
	}
}