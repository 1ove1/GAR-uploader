<?php declare(strict_types=1);

namespace GAR\Uploader\Readers\AbstractXMLReader;

use GAR\Uploader\Models\ConcreteTable;

interface ShedulerObject
{
	public function linked(string $fileName) : void;
	public function exec(ConcreteTable $model) : void;
}
