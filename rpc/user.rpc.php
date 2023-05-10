<?php
include "../autoloader.php";

// Start session
session_start();
header('Content-type: application/json');
$action = isset($_GET['action']) ? $_GET['action'] : null;


$rv = array();
switch($action) {
    case 'check-logged-in' :      
        $result = user::check_logged_in();        
        die(json_encode($result));

    case 'logout':
        user::logout();
        break;

    case 'user-login':
        if (!isset($_POST["username"]) || !isset($_POST["password"]))
        {
            http_response_code(500);
            die('post request is missing parameter in body');
        }
        $username = $_POST["username"];
        $password = $_POST["password"];

        $res =  user::validate_params($username, $password);

        if (!$res["status"])
        {
            http_response_code(404);
            die($res["error"]);
        }
    
    
        $logged_in = user::login($username, $password);
    
        if ($logged_in["status"]) 
        {        
            // var_dump($logged_in["user"]);  
            die(json_encode($logged_in["user"]));
        }
        else
        {
            http_response_code(404);
            die("wrong username or password!");
        }


    default:
        die(json_encode(['error'=>'user.rpc: missing action param']));



}


?>