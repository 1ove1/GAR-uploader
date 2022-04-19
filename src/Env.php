<?php declare(strict_types=1);

namespace GAR\Uploader;

/**
 * ENVOIRMENT ENUM
 *
 * CONTAINS ALL NEEDED INFORMATION ABOUT DB AND PATHS
 */
enum Env : string {
	case db_type  	= "mysql";
	case db 		= "address_info";
	case host 		= "localhost";
	case user 		= "user";
	case pass 		= "11899487";
	case zipPath  	= __DIR__ . "/gar_delta_xml.zip";
	case cachePath	= __DIR__ . "/.cache";
	case logPath	= __DIR__ . "/.logs";

	// if you have many ram you may change it
	case sqlInsertBuffer = "100";

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
