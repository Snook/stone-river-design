<?php
class Database {

	protected static $instance = null;

	final private function __construct() {}
	final private function __clone() {}

	/**
	* @return PDO
	*/
	public static function instance()
	{
		if (self::$instance === null)
		{
			try
			{
				self::$instance = new PDO(
						'mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE,
						DB_SERVER_USERNAME,
						DB_SERVER_PASSWORD
				);

				self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e)
			{
				die('Database connection could not be established.');
			}
		}

		return self::$instance;
	}

	/**
	* @return PDOStatement
	*/

	/* Return a single row */
	public static function f($query)
	{
		if (func_num_args() == 1)
		{
			$STH = self::instance()->query($query);
			$STH->setFetchMode(PDO::FETCH_OBJ);

			while($row = $STH->fetch())
			{
				return $row;
			}

			return false;
		}

		$args = func_get_args();

		$STH = self::instance()->query(self::autoQuote(array_shift($args), $args));
		$STH->setFetchMode(PDO::FETCH_OBJ);

		while($row = $STH->fetch())
		{
			return $row;
		}
	}

	public static function q($query)
	{
		if (func_num_args() == 1)
		{
			return self::instance()->query($query);
		}

		$args = func_get_args();

		return self::instance()->query(self::autoQuote(array_shift($args), $args));
	}

	public static function x($query)
	{
		if (func_num_args() == 1)
		{
			return self::instance()->exec($query);
		}

		$args = func_get_args();

		return self::instance()->exec(self::autoQuote(array_shift($args), $args));
	}

	public static function autoQuote($query, array $args)
	{
		$i = strlen($query) - 1;
		$c = count($args);

		while ($i--)
		{
			if ('?' === $query[$i] && false !== $type = strpos('sia', $query[$i + 1]))
			{
				if (--$c < 0)
				{
					throw new InvalidArgumentException('Too little parameters.');
				}

				if (0 === $type)
				{
					$replace = self::instance()->quote($args[$c]);
				}
				elseif (1 === $type)
				{
					$replace = intval($args[$c]);
				}
				elseif (2 === $type)
				{
					foreach ($args[$c] as &$value)
					{
						$value = self::instance()->quote($value);
					}

					$replace = '(' . implode(',', $args[$c]) . ')';
				}

				$query = substr_replace($query, $replace, $i, 2);
			}
		}

		if ($c > 0)
		{
			throw new InvalidArgumentException('Too many parameters.');
		}

		return $query;
	}

	public static function __callStatic($method, $args)
	{
		return call_user_func_array(array(self::instance(), $method), $args);
	}

}
?>