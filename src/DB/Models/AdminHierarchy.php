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
class AdminHierarchy extends ConcreteTable
{
	#[ArrayShape(['id_admin' => "string[]", 'objectid_admin' => "string[]", 'parentobjid_admin' => "string[]"])] public function setFieldsToCreate() : array
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