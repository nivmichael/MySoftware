<?php

class strings
{

    //                          Sign   Replace  , Str
    // echo str_replace_first('abc', '123', 'abcdef abcdef abcdef'); ==> 123def abcdef abcdef
    public static function str_replace_first($search, $replace, $subject)
	{
		$search = '/' . preg_quote($search, '/') . '/';
		return preg_replace($search, $replace, $subject, 1);
	}

}