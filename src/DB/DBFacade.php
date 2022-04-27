<?php declare(strict_types=1);

namespace GAR\Uploader\DB;

use GAR\Uploader\{DB\PDOAdapter\PDOElem, Env, Log, Msg};
use PDOException;

/**
 * DB FACADE CLASS
 * 
 * SINGLETON, FULL-STATIC FACADE
 * USE FOR GETTING ACTUAL BD CONNECTION
 */
class DBFacade
{
	/**
	 * @var PDOElem|null - PDO object
   */
	public static ?PDOElem $instance = null;

  /**
   *  Get curr instance of database
   * @param string $envClassName - name of conf class (Env by default)
   * @return PDOElem - PDO-object with curr db connection
   */
	public static function getInstance(string $envClassName = Env::class) : PDOElem {

		if (self::$instance === null) {
			self::$instance = self::connect($envClassName);
		} 

		return self::$instance;
	}


  /**
   *  Method to connection with database using
   *  Env.php file
   * @param string $env className of environment object
   * @return PDOElem connected PDO-object
   */
	public static function connect(string $env) : PDOElem
	{
		$conf = call_user_func($env . '::toArray');

    $PDO = new PDOElem(
      $conf['db_type'], $conf['db'],
      $conf['host'], $conf['user'],
    );

		try {

			Log::write(Msg::LOG_DB_INIT->value);
      $PDO->connect($conf['pass']);
			Log::write(Msg::LOG_COMPLETE->value);

		} catch (PDOException $exception) {
			Log::error(
				$exception,
				$conf
			);
		}

    return $PDO;
	}
}