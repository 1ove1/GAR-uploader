<?php declare(strict_types=1);

namespace GAR\Uploader\XMLReaderFactory\XMLReaders\AbstractXMLReader;

/**
 * CUSTOMREADER INTERFACE
 *
 * DEFINES METHODS THAT COULD USE FOR
 * GETTING INFO ABOUT ELEMS AND ATTRIBUTES THAT
 * SHOULD BE PARSE
 */
interface CustomReader
{
	/**
	 * return elements of xml document
	 * @return array elements names
	 */
	static function getElements() : array;

	/**
	 * return attributes of elements in xml document
	 * @return array attributes names
	 */
	static function getAttributes() : array;
}