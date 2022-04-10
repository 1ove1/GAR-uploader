<?php declare(strict_types=1);

namespace LAB2;


// path to the log directory
define('LOG_PATH', \LAB2\Env::logPath->value);

/**
 * SIMPLE LOGGER CLASS
 */
class Log
{

	/**
	 *  getting message to log and additional params (strings) 
	 * @param  string $message message to log
	 * @param  string $params  other (maybe name of files or other info)
	 * @return void
	 */
	public static function write(string $message, string ...$params) : void
	{
		if (!defined('CURR_LOG_FILE')) {
			self::launch();
		}

		self::put(sprintf("[%s]: %s %s %s", 
			self::currTime(),
			$message,
			implode(' ', $params), 
			PHP_EOL
		));
	}

	/**
	 * warinig method (making caption if expetion was throw)
	 * @param  string $message message to log
	 * @return void
	 */
	public static function warning(string $message) : void
	{

	}

	/**
	 * error method (making caption if error was throw)
	 * @param  \Throwable $excp   throwed exception
	 * @param  array      $params additional strings
	 * @return void
	 */
	public static function error(\Exception $excp, array $params = []) : void
	{

		if ($excp instanceof \PDOException) {
			$msg = Msg::LOG_DB_BAD->value;
		}

		self::put(sprintf("[%s]: %s\n%s\n%s\n",
			self::currTime(), 
			Msg::LOG_BAD->value,
			$excp, 
			http_build_query($params, '', ', ')
		));
	}

	/**
	 * create log directory if it does-nt exists
	 * @return void
	 */
	private static function launch() : void
	{
		if (!file_exists(LOG_PATH)) {
			mkdir(LOG_PATH);
		}

		define('CURR_LOG_FILE', sprintf("%s/log_%s.txt", 
			LOG_PATH, 
			str_replace(' ', '_', self::currTime())
		));

		self::put(\LAB2\Msg::LOG_LAUNCH->value . PHP_EOL);
	} 

	/**
	 * write message to the log file and echo
	 * (if script run with -l or --log flag)
	 * @param  string $message message to log
	 * @return void
	 */
	private static function put(string $message) : void 
	{
		file_put_contents(CURR_LOG_FILE, $message, FILE_APPEND);
		if (count($_SERVER['argv']) >= 2 && in_array($_SERVER['argv'][1], ['-l', '--log'])) {
			echo $message;
		}
	}

	/**
	 * return curr message format
	 * @return void
	 */
	private static function currTime() : string
	{
		return date('Y-m-d H:i:s');
	}
}