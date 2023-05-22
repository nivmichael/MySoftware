<?php

require_once '../autoload.php';
// Takes raw data from the request
header("Content-Type: application/json"); 
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);
die($data->username);
// $username   = $_REQUEST['username'];
// $password   = $_REQUEST['password'];

// var_dump($_REQUEST);
// var_dump(json_decode(array_keys($_REQUEST)[0])->username );
// var_dump(json_decode(array_keys($_REQUEST)[0])->password );

// die;

