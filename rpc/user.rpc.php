<?php
require_once '../mysoftware_autoload.class.php';

$payload = file_get_contents('php://input');
$data = json_decode($payload);
// CR: check 'action' isset, if not null
$action = $_GET["action"];
if(isset($action)==null)
    die;    

switch($action){

    case 'user_login':
    
        if(empty($data->username) || empty($data->password)) {
            // Username is null or empty so return a error message 
            $response = rpchelper::rpcerror('missing username or password field');
        }
        else {
            // Both fields username and password are OK => Calls login_user function
           
            $user = new user($data->username, $data->password);
            $db = db::connect();
            $response[] = $user->login();
        
        }
        
        break;

    default:
        // Missing action param
        $response = rpchelper::rpcerror('missing action param');
        break;
}

echo json_encode($response);

die;

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
