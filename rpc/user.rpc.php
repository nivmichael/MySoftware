<?php
require_once '../mysoftware_autoload.class.php';

// Start new or resume existing session
session_start();

$payload = file_get_contents('php://input');
$data = json_decode($payload);
$action = isset($_GET) ?? null;
$response = [
    "status" => false,
    "msg" => null,
    "data" => null,
];

switch($action){
    case 'user_login': 
        $response["status"] = false;

        if(empty($data->username) || empty($data->password)) {
            // Username is null or empty so return a error message
            $response = rpchelper::rpcerror('missing username or password field');
        }
        else {
            // Both fields username and password are OK => Calls login_user function
            $user       = new user($data->username, $data->password);
            $db         = db::connect();

            if($user->login()) {
               // HTTP Response 200 by Default
               $user->init_session();
               $response["status"] = true;
               $response["msg"] = "login was successful";
            }
            else{
                $response["status"] = false;
                $response["msg"]="login was not successful";
                http_response_code(404);
            }
        }
        break;

    case 'user_logout': 
         // HTTP Response 200 by Default

         if($user->logout()){
            $response["status"] = true;
            $response["msg"] = "logout was successful";
         }
         else{
            $response["status"] = true;
            $response["msg"] = "logout was not successful";
            http_response_code(400);
         }

        break;
    

    default:
        // Missing action param
        $response = rpchelper::rpcerror('missing action param');
        break;
}

die(json_encode($response));

/*
1. Add a $action variable that stores the $_GET param 'action'
2. Create a switch/case bloke that uses action as it's switch
3. In the 'userLogin' case - validate that we got both the username and password
4. If missing one of them, return JSON error to client and print beneath the login form
5. If both params are OK, call a method in user.class.php named login_user that gets both params
6. Create the users table in MySQL - talk with michael about changes.sql + schema.sql
*/

//var_dump($_REQUEST);
//var_dump($payload);
