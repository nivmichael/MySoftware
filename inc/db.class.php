<?php
class db
{
    private static $conn = null;

    private static $db_host = "localhost";
    private static $db_username = "root";
    private static $db_password = "";
    private static $db_name = "diana_blog";

	public static function connect()
	{
		if (!self::$conn) {
			self::$conn = mysqli_init();
			self::$conn->real_connect(db::$db_host, db::$db_username, db::$db_password, db::$db_name);
			self::$conn->set_charset('utf8');
		}

		return self::$conn;
	}
}
