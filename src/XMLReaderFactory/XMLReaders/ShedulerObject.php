<?php declare(strict_types=1);

namespace GAR\Uploader\XMLReaderFactory\XMLReaders;

use GAR\Uploader\XMLReaderFactory\XMLReaders\ConcreteReader;
use GAR\Uploader\DBFactory\Tables\ConcreteTable;

interface ShedulerObject
{
	public function linked(string $fileName) : void;
	public function exec(ConcreteTable $model) : void;
}
