<?php

class db
{
	private static $master;

	public static function connect()
	{
		if (!self::$master)
		{
			self::$master = mysqli_init();
            self::$master->real_connect("localhost", "testusr", "q1w2e3R4!", "testphp");
            self::$master->set_charset('utf8');
		}

		return self::$master;
	}
}