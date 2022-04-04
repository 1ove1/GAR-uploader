<?php declare(strict_types=1);

namespace TPO\LAB2\DBFactory\Tables\AbstractTable;

use TableItem;
use TPO\LAB2\DBFactory\DBFacade;

trait AbstractTable
{
	// ?string $name = null;
	// ?array 	$fields = null;
	
	/**
	 * Class name to class table (CamelCase to snake_case)
	 * @param  string $className Class name
	 * @return void            	 
	 */
	protected function getTableName(string $className) : void
	{
		foreach (str_split(strtolower($className)) as $key => $char) {
			if ($key !== 0 && ctype_upper($className[$key])) {
				$this->name .= '_';
			}
			$this->name .= $char;
		}
	}

	public function select(array|string $fields, ?string $coundition = null, ?string $element = null) {
		$this->PDO = DBFacade::getInstance();
		$connection = DBFacade::getInstance();

		try{
			$state = $connection->query('SELECT ' . $fields . ' FROM ' . $this->name);
		} catch (PDOException $excpetion)
		{
			echo $excpetion->getMessage . ' ' . $exception->getCode();
		}
		return $state->fetchAll(\PDO::FETCH_ASSOC);
	}
}