<?php
class rpchelper
{
    public static function rpcerror(string $error, int $errcode = 400)
    {
        http_response_code($errcode);
        return ['error'=>$error];
    }
}
