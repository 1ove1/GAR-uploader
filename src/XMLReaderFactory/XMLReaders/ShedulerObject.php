<?php declare(strict_types=1);

namespace LAB2\XMLReaderFactory\XMLReaders;

use LAB2\XMLReaderFactory\XMLReaders\ConcreteReader;
use LAB2\DBFactory\Tables\ConcreteTable;

interface ShedulerObject
{
	public function linked(string $fileName) : void;
	public function excec(ConcreteTable $model) : void;
}
