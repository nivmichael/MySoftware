<?php

class db
{
	private static $conn = null;
	private static $host = "localhost";
	private static $username = "testusr";
	private static $password = "q1w2e3R4!";
	private static $db = "testphp";

	private static $replaceSign = "$%$";

	public static function connect()
	{
		if (!self::$conn) {
			self::$conn = mysqli_init();
			self::$conn->real_connect(db::$host, db::$username, db::$password, db::$db);
			self::$conn->set_charset('utf8');
		}

		return self::$conn;
	}

	public static function executeQuery($query, ...$params)
	{	
		$q      = "SELECT username FROM users WHERE username='$%$' AND password='$%$'";
		$newQuery = "sadas";
		foreach ($params as $p) {
			$newQuery = strings::str_replace_first(db::$replaceSign, $p, $q);
			
		}
		//$result = $conn->query($q);
	}
}
