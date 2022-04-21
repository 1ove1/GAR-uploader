<?php declare(strict_types=1);

namespace GAR\Uploader\Models;

use GAR\Uploader\Models\ConcreteTable;


/**
 * ADDRESS INFO CLASS-MODEL
 *
 * EXTENDS CONCRETE TABLE AND USING FOR COMMUNICATE
 * WITH TABLE 'address_info'
 */
class AdminHierarchi extends ConcreteTable 
{
	public function getFieldsToCreate() : array 
	{
		return [
			'id_admin' => [
				'CHAR(50)',
			],
			'objectid_admin' => [
				'CHAR(50)',
			],
			'parentobjid_admin' => [
				'CHAR(50)',
			],
		];
	}
}