<?php
$payload = file_get_contents('php://input');
$data = json_decode($payload);
// CR: check 'action' isset, if not null
$action = $_GET["action"];

switch($action){
    case 'user_login':
        if(empty($data->username) || empty($data->password)) {
            /* Username is null or empty so return a error message */
            $response = ['error'=>'missing username or password field'];
            http_response_code(400);
        }
        else {
            /* Both fields username and password are OK => Calls login_user function*/
            $response = user_login($data->username, $data->password);    
        }
        
        break;

    default:
        /* Missing action param */
        $response = ['error'=>'missing action param'];
        http_response_code(400);
        break;
}

echo json_encode($response);
// CR: there's no functionality in rpc - only in classes. this function ius part ot user class
function user_login($username, $password) {
    $response = ['success'=>'user login was successful'];
    // If user exists in Database return 200
    http_response_code(200);
    return $response;
}

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
