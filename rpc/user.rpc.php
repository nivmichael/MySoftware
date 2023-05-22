<?php

require_once '../autoload.php';
// Takes raw data from the request
header("Content-Type: application/json"); 
$json = file_get_contents('php://input');
var_dump($_GET);
var_dump($_GET['action']);
// Converts it into a PHP object
$data = json_decode($json);
die($data->username);
// $username   = $_REQUEST['username'];
// $password   = $_REQUEST['password'];

// var_dump($_REQUEST);
// var_dump(json_decode(array_keys($_REQUEST)[0])->username );
// var_dump(json_decode(array_keys($_REQUEST)[0])->password );

// die;

// CR - add a switch case for action 
// Add validation fo username & password - if one missing retur error "missing credentials" and show error beneath the login
// Create users table
// Create a login function in user.class.php
// Validate agains the DB with mysqli
// Make sure to sanitize the unam and pwd

