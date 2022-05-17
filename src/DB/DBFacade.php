<?php declare(strict_types=1);

namespace GAR\Uploader\DB;

use GAR\Uploader\{DB\PDOAdapter\DBAdapter,
  DB\PDOAdapter\PDOObject,
  Env,
  Log,
  Msg};
use InvalidArgumentException;
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
	 * @var DBAdapter|null - PDO object
   */
	public static ?DBAdapter $instance = null;

  /**
   *  Get curr instance of database
   * @param string $envClassName - name of conf class (Env by default)
   * @return DBAdapter - PDO-object with curr db connection
   */
	public static function getInstance(string $envClassName = Env::class) : DBAdapter
  {

		if (self::$instance === null) {
			self::$instance = self::connectViaPDO($envClassName);
		} 

		return self::$instance;
	}


  /**
   *  Method to connection with database using
   *  Env.php file
   * @param string $env className of environment object
   * @return PDOObject connected PDO-object
   */
	public static function connectViaPDO(string $env) : PDOObject
	{
		$conf = call_user_func($env . '::toArray');

    $PDO = new PDOObject(
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

  public static function genTableNameByClassName(string $className) : string
  {
    // remove some ..\\..\\..\\ClassName prefix
    $arrStr = explode('\\', $className);
    $className = end($arrStr);

    $tableName = '';
    foreach (str_split(strtolower($className)) as $key => $char) {
      if ($key !== 0 && ctype_upper($className[$key])) {
        $tableName .= '_';
      }
      $tableName .= $char;
    }

    if (!preg_match('/^[a-zA-Z][a-zA-Z_]{1,18}$/',$tableName)) {
      throw new InvalidArgumentException('invalid table name :' . $tableName);
    }

    return $tableName;
  }
}