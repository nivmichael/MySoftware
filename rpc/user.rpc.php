<?php

require_once '../autoload.php';
session_start();
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

        die(json_encode($res));
        break;

    case 'logout':
        session_unset();
        break;

    case 'isLoggedIn':

        if (isset($_SESSION["logged_in"])) {
            $res = [
                "logged_in"    => true,
                "message"      => "User Logged in Successfuly",
                "username"     => $_SESSION["username"],
                "last_login"   => $_SESSION["last_login"],
            ];
            die(json_encode($res));
        }



        break;

    default:
        die;
        break;
}

die();









// V -- CR - add a switch case for action
// V -- Add validation for username & password - if one missing retur error "missing credentials" and show error beneath the login
// V -- Create users table
// V -- Create a login function in user.class.php 
// V -- Validate agains the DB with mysqli 
// V -- Make sure to sanitize the unam and pwd 
