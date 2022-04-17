<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use GAR\Uploader\XMLReaderFactory\{
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