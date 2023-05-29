<?php

class db
{
	private static $conn = null;
	private static $host = "localhost";
	private static $username = "testusr";
	private static $password = "q1w2e3R4!";
	private static $db = "testphp";

	public static function connect()
	{
		if (!self::$conn) {
			self::$conn = mysqli_init();
			self::$conn->real_connect(db::$host, db::$username, db::$password, db::$db);
			self::$conn->set_charset('utf8');
		}

		return self::$conn;
	}
}
