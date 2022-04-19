<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use GAR\Uploader\Readers\AbstractXMLReader\OpenXMLFromZip;

class OpenXMLFromZipTest extends TestCase
{
	use OpenXMLFromZip;

	public function testExtractingFileFromZip() {
		// creating simple zip archive with file test.txt
		$zip = new \ZipArchive;
		$zipName = './test.zip';
		$fileName = 'test.txt';
		$data = "simple data for test case\n";

		if ($zip->open($zipName, \ZipArchive::CREATE) !== TRUE) {
			throw new Exception('zip ' . $zipName . ' was not created');
		}
		$zip->addFromString($fileName, $data);
		$zip->close();

		// testing our methods
		try {
			$this->extractFileFromZip($zipName, $fileName, './');
			$this->assertEquals($data, file('./' . $fileName)[0]);
		} finally {
			 unlink($zipName);
			 unlink('./' . $fileName);
		}

	}

	public function testOpenXmlFile() {
		// creating xml file
		$file = './test.xml';
		$data = '';

		file_put_contents('test.xml', $data);

		try {
			$reader = $this->openXML($file);
			$this->assertIsObject($reader);
		} finally {
			$reader->close();
			unlink($file);	
		}
	}
};