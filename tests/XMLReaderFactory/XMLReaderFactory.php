<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use LAB2\XMLReaderFactory\{
	XMLReaderFactory,
	XMLReaders\ConcreteReader
};

class XMLReaderFactoryTest extends TestCase
{
	public function testFullParseOfAddressObject() 
	{
		XMLReaderFactory::excecAddrObj();
	}
}