<?php declare(strict_types=1);

namespace GAR\Uploader\XMLReaderFactory;

use GAR\Uploader\XMLReaderFactory\XMLReaders\{
	ConcreteReader,
	AddressObject,
	AsHouses
};

const FILES = [
	'AS_HOUSES' => 'AS_HOUSES', 
	'ADDR_OBJ' => 'AS_ADDR_OBJ'
];


class XMLReaderFactory
{
	const regions = [
		'1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 
		'11', '12', '13', '14', '15', '16', '17', '18', '19', '20', 
		'21', '22', '23', '24', '25', '26', '27', '28', '29', '30', 
		'31', '32', '33', '34', '35', '36', '37', '38', '39', '40', 
		'41', '42', '43', '44', '45', '46', '47', '48', '49', '50', 
		'51', '52', '53', '54', '55', '56', '57', '58', '59', '60', 
		'61', '62', '63', '64', '65', '66', '67', '68', '69', '70', 
		'71', '72', '73', '74', '75', '76', '77', '78', '79', '80', 
		'81', '82', '83', '84', '85', '86', '87', '88', '89', '91', 
		'92', '99',

	]; 	
	
	public static function execAddrObj() : ConcreteReader
	{
		return self::prepare(new AddressObject(), FILES['ADDR_OBJ']);

	}
	
	public static function execHouses() : ConcreteReader
	{
		return self::prepare(new AsHouses(), FILES['AS_HOUSES']);

	}


	private static function prepare(ConcreteReader $reader, string $file) : ConcreteReader
	{
		foreach (self::regions as $value) {
			$path = $value . '/' . $file;
			$reader->linked($path);
		}

		return $reader;
	}
}
