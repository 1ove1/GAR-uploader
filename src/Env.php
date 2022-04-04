<?php declare(strict_types=1);

namespace TPO\LAB2;

enum Env : string {
	case db_type 	= "mysql";
	case db 		= "address_info";
	case host 		= "localhost";
	case user 		= "user";
	case pass 		= "password";
}