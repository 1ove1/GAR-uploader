<?php declare(strict_types=1);

namespace GAR\Uploader\XMLReader\Readers\AbstractReaders;


use GAR\Uploader\DB\Table\AbstractTable\SQL\QueryModel;

interface SchedulerObject
{
	public function linked(string $fileName) : void;
	public function exec(QueryModel $model) : void;
}
