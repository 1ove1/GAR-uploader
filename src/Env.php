<?php declare(strict_types=1);

namespace LAB2;

enum Env : string {
	case db_type 	= "mysql";
	case db 		= "address_info";
	case host 		= "localhost";
	case user 		= "user";
	case pass 		= "password";
	case zipPath  	= __DIR__ . "/gar_delta_xml.zip";
	case cachePath	= __DIR__ . "/cache";
}