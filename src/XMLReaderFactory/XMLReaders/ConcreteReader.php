<?php declare(strict_types=1);

namespace LAB2\XMLReaderFactory\XMLReaders;

use LAB2\XMLReaderFactory\XMLReaders\AbstractXMLReader\{
	AbstractXMLReader, 
	IteratorXML, 
	OpenXMLFromZip, 
	CustomReader
};
use LAB2\XMLReaderFactory\XMLReaders\ShedulerObject;
use LAB2\DBFactory\Tables\ConcreteTable;
use LAB2\{Env, Msg, Log};

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
	}

	/**
	 * method thath execute main object function
	 * @param  ConcreteTable $model model of concrete table
	 * @return void
	 */
	public function excec(ConcreteTable $model) : void
	{
		foreach ($this as $value) {
			$this->excecDoWork($model, $value);
		}

		$this->__destruct();

		if (!is_null($this->linkToAnother)) {
			$this->linkToAnother->excec($model);
		}
	}

	/**
	 * procedure that contains main operations from excec method
	 * @param  ConcreteTable $model table model
	 * @param  array         $value current parse element
	 * @return void
	 */
	protected abstract function excecDoWork(ConcreteTable $model, array $value) : void;

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
			} catch (Exception $excep) {
				Log::error($excep, ['fileName' => $fileName]);
			}
		}

		// open xml file
		try{
			Log::write(Msg::LOG_XML_READ->value, $this->fileName);
			$this->reader = $this->openXML($this->pathToXml);

		} catch (Exception $excep){
			Log::error($excep, ['fileName' => $this->fileName]);
		}

		$this->next();
	}
}