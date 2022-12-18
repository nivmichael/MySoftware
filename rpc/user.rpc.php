<?php
include "../autoloader.php";
session_start();

$username = $password = "";
$rpc_result = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $req = file_get_contents('php://input');
    $data = json_decode($req);
    if (isset($data->{"action"})) {
        switch ($data->{"action"}) 
        {
            case "login": 
            {
                $username = $data->{"username"};
                $password = $data->{"password"};
                
                // Validates that username,password exist, username is valid email
                $rpc_result = validate_login_data($rpc_result, $username,$password);

                if (!isset($rpc_result['status']) || $rpc_result['status'] !== false) {
                    // Query if user exist and create session
                    $login = user::login($username,$password);
                    $rpc_result = [
                                    'status' => ($login)? true:false,
                                    'data' => ($login)? 'user is logged in':'user or password are incorrect',
                                    'name' => ($login)? $_SESSION["name"]:null,
                                    'last_login' => ($login)? $_SESSION["last_login"]:null,
                                    ];
                }
                
            }
        }
    } else {
        $rpc_result = [
            'status' => false,
            'data' => 'missing action',
            ];
    }
}
else if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
    if (isset($_GET['action'])) {
        switch ($_GET['action']) 
        {
            case "check_if_logged": 
            {
                if (isset($_SESSION["user_id"])) {
                    $user = new user($_SESSION["user_id"], $_SESSION["name"], $_SESSION["last_login"]); 
                    $rpc_result = [
                        'status' => true,
                        'name' => $_SESSION["name"],
                        'last_login' => $_SESSION["last_login"],
                        ];
                }
                else {
                    $rpc_result = [
                        'status' => false,
                        ];
                }
            }
            case "logout": 
            {
                user::logout();
            }
        }
    }
}

// Validates that username,password exist, username is valid email
function validate_login_data($rpc_result, $username, $password) 
{
    // Validator that username exist
    if (!$username) {
        $rpc_result = [
            'status' => false,
            'data' => 'username is required',
          ];
    }
    // Validator that username is an email
    else if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $rpc_result = [
            'status' => false,
            'data' => 'username is not valid (should be an email)',
          ];
    }
    // Validator that password exist
    else if (!$password) {
        $rpc_result = [
            'status' => false,
            'data' => 'password is required',
          ];
    }
    return $rpc_result;
}


die(json_encode($rpc_result));
?>