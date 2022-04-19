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
	/**
	 *  PDO object
	 *
	 * @var \PDO|null
	 */
	public static ?\PDO $instance = null;

	/**
	 *  Get curr instance of database
	 * @param  string   curr environmant object path
	 * @return \PDO 		PDO-object with curr db connection
	 */
	public static function getInstance(?string $envClassName = null) : \PDO {
		
		if (self::$instance === null || !is_null($envClassName)) {
			if (is_null($envClassName)) {
				$envClassName = Env::class;
			}
			self::$instance = self::connect($envClassName);
		} 

		return self::$instance;
	}


	/**
	 *  Method to connetcn with database using
	 *  Env.php file
	 * @param 	strnig	$env 	className of environmant object
	 * @return \PDO connected PDO-object
	 */
	public static function connect(string $env) : \PDO
	{
		$conf = call_user_func($env . '::toArray');

		$db_type = $conf['db_type'];
		$host = $conf['host'];
		$db = $conf['db'];
		$user = $conf['user'];
		$pass = $conf['pass'];

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