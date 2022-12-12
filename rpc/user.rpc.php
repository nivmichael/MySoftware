<?php
include "../autoloader.php";
session_start();

$username = $password = "";
// switch case of $_POST['action'] 
// case 'login' - do login 
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $req = file_get_contents('php://input');
    $data = json_decode($req);
    if ($action = $data->{"action"}) {
        switch ($action) 
        {
            case "login": 
            {
                $username = $data->{"username"};
                $password = $data->{"password"};
                
                // Validates that username,password exist, username is valid email
                validate_login_data($username,$password);

                // Query if user exist and create session
                $login = user::login($username,$password);
                echo (json_encode([
                    'status' => ($login)? true:false,
                    'data' => ($login)? 'user is logged in':'user or password are incorrect',
                    ]));
            }
        }
    }
}

// Validates that username,password exist, username is valid email
function validate_login_data($username,$password) 
{
    // Validator that username exist
    if (!$username) {
        die(json_encode([
            'login' => false,
            'data' => 'username is required',
          ]));
    }
    // Validator that username is an email
    else if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        die(json_encode([
            'status' => false,
            'data' => 'username is not valid (should be an email)',
          ]));
    }
    // Validator that password exist
    else if (!$password) {
        die(json_encode([
            'status' => false,
            'data' => 'password is required',
          ]));
    }
}


die;
?>