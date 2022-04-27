<?php declare(strict_types=1);

namespace GAR\Uploader\DB\Models;

use GAR\Uploader\Models\ConcreteTable;


/**
 * ADDRESS INFO CLASS-MODEL
 *
 * EXTENDS CONCRETE TABLE AND USING FOR COMMUNICATE
 * WITH TABLE 'address_info'
 */
class MunHierarchy extends ConcreteTable
{
	public function setFieldsToCreate() : array
	{
		return [
			'id_mun' => [
				'CHAR(50)',
			],
			'objectid_mun' => [
				'CHAR(50)',
			],
			'parentobjid_mun' => [
				'CHAR(50)',
			],
      'oktmo_mun' => [
				'CHAR(50)',
			],
		];
	}
}