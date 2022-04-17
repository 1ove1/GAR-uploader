<?php declare(strict_types=1);

namespace GAR\Uploader\DBFactory\Tables;

use GAR\Uploader\DBFactory\Tables\ConcreteTable;


/**
 * ADDRESS INFO CLASS-MODEL
 *
 * EXTENDS CONCRETE TABLE AND USING FOR COMMUNICATE
 * WITH TABLE 'address_info'
 */
class AddressInfo extends ConcreteTable 
{
	public function getFieldsToCreate() : array 
	{
		return [
			'id_addr' => [
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
			'name' => [
				'CHAR(100)',
			],
			'typename' => [
				'CHAR(50)',
			],
		];
	}
}