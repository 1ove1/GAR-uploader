<?php declare(strict_types=1);

namespace GAR\Uploader\DBFactory;

use GAR\Uploader\{Env, Log, Msg};

/**
 * DBFACADE CLASS
 * 
 * SINGLETON, FULL-STATIC FACADE
 * USE FOR GETTING ACTUAL BD CONNECTION
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


	/**
	 *  Method to connetcn with database using
	 *  Env.php file
	 * @return \PDO connected PDO-object
	 */
	public static function connect() : \PDO
	{
		$db_type = Env::db_type->value;
		$host = Env::host->value;
		$db = Env::db->value;
		$user = Env::user->value;
		$pass = Env::pass->value;

		try {
			Log::write(Msg::LOG_DB_INIT->value);

			$PDO = new \PDO($db_type . ':host=' . $host . ';dbname=' . $db, $user, $pass);

			Log::write(Msg::LOG_COMPLETE->value);
		} catch (\PDOException $excep) {
			Log::error(
				$excep,
				compact('db_type', 'host', 'user', 'pass')
			);
		}

		return $PDO;
	}
}