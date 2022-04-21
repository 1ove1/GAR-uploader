<?php declare(strict_types=1);

namespace GAR\Tests;


/**
 * TEST ENVOIRMENT ENUM
 *
 * CONTAINS ALL NEEDED INFORMATION ABOUT DB AND PATHS FOR TEST ENV
 */
enum TestEnv : string {
	case db_type  	= "mysql";
	case db 		= "address_info_tests";
	case host 		= "localhost";
	case user 		= "user";
	case pass 		= "password";
	case zipPath  	= __DIR__ . "/gar_delta_xml.zip";
	case cachePath	= __DIR__ . "/.cache";
	case logPath	= __DIR__ . "/.logs";

	public static function toArray() : array
	{
		return [
			'db_type' => self::db_type->value,
			'db' => self::db->value,
			'host' => self::host->value,
			'user' => self::user->value,
			'pass' => self::pass->value,
			'zipPath' => self::zipPath->value,
			'cachePath' => self::cachePath->value,
			'logPath' => self::logPath->value,
		];
	}
}