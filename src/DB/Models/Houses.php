<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Models;

use GAR\Uploader\Models\ConcreteTable;


/**
 * AS HOUSES CLASS-MODEL
 *
 * EXTENDS CONCRETE TABLE AND USING FOR COMMUNICATE
 * WITH TABLE 'address_info'
 */
class Houses extends ConcreteTable 
{
	public function setFieldsToCreate() : array
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