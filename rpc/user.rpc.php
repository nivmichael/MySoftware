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

$user = new user();

switch($action) {
    case 'user_login': 
        $response["status"] = false;

        if(empty($data->username) || empty($data->password)) {
            // Username is null or empty so return a error message
            $response = rpchelper::rpcerror('missing username or password field');
        }
        else {
            // Both fields username and password are OK => set username and password 
            // And call login_user function
            $user->set_username($data->username);
            $user->set_password($data->password);            
            $db         = db::connect();

            $user_login = $user->login();
            if($user_login) {
                $user->set_id($user_login);
                // HTTP Response 200 by Default
                $user->init_session();
                $response["status"] = true;
                $response["msg"] = "login was successful";
            }
            else {
                $response["status"] = false;
                $response["msg"]="login was not successful";
                http_response_code(404);   
            }
        }
        break;

    case 'user_logout': 
         // HTTP Response 200 by Default
         if($user->logout()) {
            $response["status"] = true;
            $response["msg"] = "logout was successful";
         }
         else {
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
1. Create a blog_posts table
2. Create a form to upload a post with params we have in the git readme
3. Creat a blog.rpc.file to handle the call
*/

