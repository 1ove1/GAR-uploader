<?php declare(strict_types=1);

namespace LAB2\XMLReaderFactory\XMLReaders\AbstractXMLReader;

/**
 * TRAIT ITERATORXML
 *
 * IMPLEMENTS METHODS IN ABSTRACTXMLREADER
 */
trait IteratorXML
{
	/**
	 * 	ITERATORS METHODS
	 */
	
	/**
	 *  findes concrete node element with concrete attributes or return outer xml string
	 * @return array mapping attributes of node
	 */
	public function current(): array
	{
		$data = [];

		if (!is_null($this->attrs)) {
			foreach ($this->attrs as $name) {
				$data[strtolower($name)] = $this->reader->getAttribute($name);
			}
		} else {
			$data[] = $this->reader->readOuterXml();
		}

		return $data;
	}

	/**
	 * 	no available
	 * @return null
	 */
	public function key(): mixed
	{
		return $this->fileName;
	}

	/**
	 *  searching next node with xml element or make reader null
	 * @return void
	 */
	public function next(): void
	{
		while($this->reader->read()) {

			if ($this->reader->nodeType == \XMLReader::ELEMENT)
			{
				if (is_null($this->elems)) {
					return;
				} else if (in_array($this->reader->localName, $this->elems)) {
					return;
				}
			}
		}
		$this->reader = null;
	}

	/**
	 *  init the xmlreader
	 * @return void
	 */
	public function rewind(): void
	{
		$this->reader = $this->openXML($this->pathToXml);
		$this->next();
	}

	/**
	 *  check if reader is null
	 * @return bool  flag for end-iteration
	 */
	public function valid(): bool
	{
		return !is_null($this->reader);
	}

}