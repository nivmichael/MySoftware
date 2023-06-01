<?php
class rpchelper
{
    // Method pupose: handles error response
    public static function rpcerror(string $error, int $errcode = 400)
    {
        http_response_code($errcode);
        return [
            'status' => false,
            'msg'    => $error
        ];
    }

    // Method pupose: handles success response
    public static function rpcsuccess(string $success)
    {
        // HTTP response code is 200 by default
        return [
            'status' => true,
            'msg'    => $success
        ];
    }
}
