<?php declare(strict_types=1);

namespace LAB2\XMLReaderFactory\XMLReaders\AbstractXMLReader;


trait OpenXMLFromZip
{
	/**
	 *  Extracting concrete file from zip archive into temp floder
	 * @param  string $pathToZip  path to zip archive
	 * @param  string $fileName   name of file or path in zip
	 * @param  string $saveFloder path to temp floder
	 * @return string             return full path to extract file
	 */
	public function extractFileFromZip(string $pathToZip, 
									   string $fileName, 
									   string $saveFloder) : string
	{
		$zip = new \ZipArchive;
		if ($zip->open($pathToZip) === TRUE) {
			$zip->extractTo($saveFloder, $fileName);
			$zip->close();
		} else {
			throw Exception('invalid operation: open xml file ' . 
							$fileName . ' from ' . $pathToZip);
		}
		return $saveFloder . $fileName;
	}

	/**
	 *  Method for open xml files from the path param
	 * @param  string $pathToFile path to the concrete xml file
	 * @return \XMLReader         XMLReader object
	 */
	public function openXML(string $pathToFile) : \XMLReader
	{
		return \XMLReader::open($pathToFile);
	}
}