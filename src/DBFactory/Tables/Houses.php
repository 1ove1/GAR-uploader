<?php declare(strict_types=1);

namespace GAR\Uploader\Models;

use GAR\Uploader\Models\ConcreteTable;


/**
 * AS HOUSES CLASS-MODEL
 *
 * EXTENDS CONCRETE TABLE AND USING FOR COMMUNICATE
 * WITH TABLE 'address_info'
 */
class Houses extends ConcreteTable 
{
	public function getFieldsToCreate() : array 
	{
		return [
			'id_houses' => [
				'INTEGER', 
				'auto_increment', 
				'PRIMARY KEY',
			],
			'id' => [
				'CHAR(50)',
			],
			'objectid' => [
				'CHAR(50)',
			],
			'objectguid' => [
				'CHAR(50)',
			],
			'housenum' => [
				'CHAR(100)',
			],
			'housetype' => [
				'CHAR(50)',
			],
		];
	}
}