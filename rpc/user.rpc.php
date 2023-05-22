<?php

require_once '../autoload.php';
// Takes raw data from the request
header("Content-Type: application/json");
$json = file_get_contents('php://input');

$action = $_GET['action'] ?? null;
unset($_GET['action']);

if (!$action)
    return http_response_code(400);

switch ($action) {
    case 'loginUser':
        $data = json_decode($json);
        $user = new user(0, $data->username, $data->password);
        if (!$user->validate()) {
            http_response_code(400);
            die("username or password does not match requiremnts");
        }
        if (!$user->login()) {
            http_response_code(400);
            die("username or password does not exists");
        }
        var_dump("Success Login");
        break;

    default:
        die;
        break;
}

// Converts it into a PHP object

die("Logged in Successfuly");

// CR - add a switch case for action
// Add validation for username & password - if one missing retur error "missing credentials" and show error beneath the login
// Create users table
// Create a login function in user.class.php 
// Validate agains the DB with mysqli 
// Make sure to sanitize the unam and pwd 
