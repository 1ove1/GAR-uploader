<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use GAR\Uploader\{Log, Msg};

const FOR_TEST = 'test message';

class Log extends TestCase
{
	public function ignoretestCreate()
	{
		$pathToFile = '';
		$logData = '';

		if (!defined('CURR_LOG_FILE')) {
			$pathToFile = sprintf(
				"%s/log_%s.txt", 
				LOG_PATH, date('Y-m-d_H:i:s')
			);
		} else {
			$pathToFile = constant('CURR_LOG_FILE');
			$logData = implode(file($pathToFile));
		}

		try {	
			Log::write(FOR_TEST);
			
			$logData .= sprintf("[%s]: %s  %s", 
				date('Y-m-d H:i:s'), FOR_TEST, PHP_EOL);

			if (!defined('CURR_LOG_FILE')) {
				$pathToFile = sprintf(
					"%s/log_%s.txt", 
					LOG_PATH, date('Y-m-d_H:i:s')
				);

			} else {
				$pathToFile = constant('CURR_LOG_FILE');
			}

			sleep(1);

			Log::write(FOR_TEST);

			$logData .= sprintf("[%s]: %s  %s", 
				date('Y-m-d H:i:s'), FOR_TEST, PHP_EOL);

			$this->assertFileExists($pathToFile);
			$this->assertStringEqualsFile($pathToFile, $logData);			
		} finally {
			unlink($pathToFile);
		}
	}
}