<?php declare(strict_types=1);

namespace GAR\Uploader\XMLReaderFactory\XMLReaders;

use GAR\Uploader\XMLReaderFactory\XMLReaders\AbstractXMLReader\{
	AbstractXMLReader, 
	IteratorXML, 
	OpenXMLFromZip, 
	CustomReader
};
use GAR\Uploader\XMLReaderFactory\XMLReaders\ShedulerObject;
use GAR\Uploader\DBFactory\Tables\ConcreteTable;
use GAR\Uploader\{Env, Msg, Log};

// define paths
define('ZIP_PATH', ENV::zipPath->value);
define('CACHE_PATH', ENV::cachePath->value);

abstract class ConcreteReader extends AbstractXMLReader implements CustomReader, ShedulerObject
{
	use IteratorXML, OpenXMLFromZip;

	protected ?ConcreteReader $linkToAnother = null;

	/**
	 * simplifiy construct from abstractreader using Env.php
	 * @param string $fileName name of concrete xml file
	 */
	function __construct(string $fileName = '')	
	{
		parent::__construct(ZIP_PATH, $fileName, CACHE_PATH);

		// task reporting
		Log::addTask(1);
	}

	function __destruct()
	{
		parent::__destruct();

		// task reporting
		Log::removeTask(1);
	}

	/**
	 * method thath execute main object function
	 * @param  ConcreteTable $model model of concrete table
	 * @return void
	 */
	public function exec(ConcreteTable $model) : void
	{
		foreach ($this as $value) {
			$this->execDoWork($model, $value);
		}

		$this->__destruct();

		if (!is_null($this->linkToAnother)) {
			$this->linkToAnother->exec($model);
		} else {
			$model->save();
		}
	}

	/**
	 * procedure that contains main operations from excec method
	 * @param  ConcreteTable $model table model
	 * @param  array         $value current parse element
	 * @return void
	 */
	protected abstract function execDoWork(ConcreteTable $model, array $value) : void;

	/**
	 *  method from ShedulerObject
	 *  creating ling to the chiled object by linkToAnother
	 * @param  string $fileName name of concrete file
	 * @return void
	 */
	public function linked(string $fileName) : void
	{
		if (!is_null($this->linkToAnother)) {
			$this->linkToAnother->linked($fileName);
		} else {
			$this->linkToAnother = new $this($fileName);
		}
	}

	/**
	 *  overrided method rewind from trait IteratorXML
	 * @return void
	 */
	public function rewind() : void 
	{
		// empty initialization
		if (empty($this->fileName)) {
			return;
		}

		// extract if it none
		if (is_null($this->pathToXml) || file_exists($this->pathToXml)) {
			try{
				Log::write(Msg::LOG_XML_EXTRACT->value, $this->fileName);
				$this->init();
			} catch (\Exception $excep) {
				Log::error($excep, ['fileName' => $this->fileName]);
			}
		}

		// open xml file
		try{
			Log::write(Msg::LOG_XML_READ->value, $this->fileName);
			
			if (!is_null($this->pathToXml)) {
				$this->reader = $this->openXML($this->pathToXml);
			} else {
				throw new \Exception('unknown path to xml file ' . $this->fileName);
			}
		} catch (\Exception $excep){
			Log::error($excep, ['fileName' => $this->fileName]);
		}

		$this->next();
	}
}