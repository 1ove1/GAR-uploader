<?php declare(strict_types=1);

namespace GAR\Uploader\Readers;

use GAR\Uploader\Readers\ConcreteReader;
use GAR\Uploader\Models\ConcreteTable;

interface ShedulerObject
{
	public function linked(string $fileName) : void;
	public function exec(ConcreteTable $model) : void;
}
