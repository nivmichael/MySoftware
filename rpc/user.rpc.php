<?php

require_once '../autoload.php';
session_start();
// Takes raw data from the request
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$action = $_GET['action'] ?? null;
$res = null;

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
        }
        break;

    default:
        break;
}

die(json_encode($res));
