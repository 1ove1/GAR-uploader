<?php declare(strict_types=1);

namespace LAB2\DBFactory;

use LAB2\Env;

/**
 * 	Some special funciton for bd connection here
 */
class DBFacade
{
	static ?\PDO $instance = null;

	/**
	 *  Get curr instance of database
	 * @return PDO 	PDO-object with curr db connection
	 */
	public static function getInstance() : \PDO {
		
		if (self::$instance === null) {
			self::$instance = self::connect();

		} 

		return self::$instance;
	}

	public static function connect() : \PDO
	{
		$db_type = Env::db_type->value;
		$host = Env::host->value;
		$db = Env::db->value;
		$user = Env::user->value;
		$pass = Env::pass->value;

		try {
			$PDO = new \PDO($db_type . ':host=' . $host . ';dbname=' . $db, $user, $pass);
		} catch (PDOException $exception) {
			echo $exception->getMessage() . $exception->getCode();
		}

		return $PDO;
	}
}