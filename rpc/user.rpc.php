<?php
require_once '../mysoftware_autoload.class.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start new or resume existing session
session_start();

$payload = file_get_contents('php://input');
$data    = json_decode($payload);
$action  = null;

if (isset($_GET)) 
{
    $action = $_GET["action"];
}

$response = [
    "status" => false,
    "msg"    => null,
    "data"   => null
];

$user = new user();

switch($action) 
{
    case 'user_login': 
        $response["status"] = false;

        if(empty($data->username) || empty($data->password)) 
        {
            // Username is null or empty so return a error message
            $response = rpchelper::rpcerror('missing username or password field');
        }
        else 
        {
            // Both fields username and password are OK => set username and password 
            // And call login_user function from user.class.php file
            $user = new user($data->username, $data->password);
            // Checks if user exists in database
            $id = $user->login();

            if($id) 
            {
                // HTTP Response 200 by Default
                $user->init_session($id);
                $response = rpchelper::rpcsuccess('login was successful');  
            }
            else
            {
                // Login was not successful(USER NOT FOUND in users table)
                // => set message into response and return http code 404
                $response = rpchelper::rpcerror('login was not successful - user does not exist', 404);  
            }
        }
        break;

    case 'user_logout': 
         // HTTP Response 200 by Default
         if($user->logout()) 
         {
            $response = rpchelper::rpcsuccess('logout was successful');  
         }
         else 
         {
            // Logout was not successful => set message into response and return http code 500
            $response = rpchelper::rpcerror('logout was not successful', 500);  
         }

        break;
    
    case 'is_login': 
    {
        $response["status"] = isset($_SESSION["user_id"]) ? true : false;

        break;
    }
    default:
        // Missing action param
        $response = rpchelper::rpcerror('missing action param');
        break;
}

die(json_encode($response));

