<?php
//$payload = file_get_contents('php://input');
$data = json_decode($payload);
$action = var_dump($_GET);

switch($action){
    case 'user_login':
        if(empty($data->username)) {
            /* Username is null or empty so print a message 
            before terminating the script */
            die(json_encode(['error'=>'user.rpc.php: missing username field']));
        }
        /* Password is null or empty so print a message 
        before terminating the script */
        else if(empty($data->password)){
            die(json_encode(['error'=>'user.rpc.php: missing password field']));
        }
        /* Both fields username and password are OK => Calls login_user function*/
        else {
            user_login($data->username,$data->password);
        }
        break;

    default:
        die(json_encode(['error'=>'user.rpc.php: missing action param']));
        break;
}

function user_login($username,$password) {

}

// echo "username: ".$data->username.", password: ".$data->password;

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
die;