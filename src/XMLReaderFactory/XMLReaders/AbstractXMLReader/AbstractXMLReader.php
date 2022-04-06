<?php declare(strict_types=1);

namespace LAB2\XMLReaderFactory\XMLReaders\AbstractXMLReader;

abstract class AbstractXMLReader implements Iterator
{
	private string $name;
	private string $pathToXml;
	private string $pathToSaveFloder;
	private ?\XMLReader $reader = null;

	public function __construct(string $pathToZip, 
								string $fileName,
								string $cachePath)
	{
		// extracting xml from zip
		$this->pathToXml = $this->extractFileFromZip($pathToZip, $fileName, $cachePath);

		// getting some paths
		$dropPath = implode('/', $this->pathToXml);
		$this->name = array_pop($dropPath);
		$this->saveFloder = explode('/', $dropPath);

		$this->reader = $this->openXML($this->pathToXML);
	}


	/**
	 *  Extracting concrete file from zip archive into temp floder
	 * @param  string $pathToZip  path to zip archive
	 * @param  string $fileName   name of file or path in zip
	 * @param  string $saveFloder path to temp floder
	 * @return string             return full path to extract file
	 */
	public abstract function extractFileFromZip(string $pathToZip, 
												string $fileName, 
												string $saveFloder) : string;

	/**
	 *  Method for open xml files from the path param
	 * @param  string $pathToFile path to the concrete xml file
	 * @return \XMLReader         XMLReader object
	 */
	public abstract function openXML(string $pathToFile) : \XMLReader;

	/**
	 * 	ITERATORS METHODS
	 */
	public abstract function current(): mixed;
	public abstract function key(): mixed;
	public abstract function next(): void;
	public abstract function rewind(): void;
	public abstract function valid(): bool;
}