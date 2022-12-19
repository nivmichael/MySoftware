<?php
include "../autoloader.php";
session_start();

$rpc_result = [
                "status" => false,
                "data"   => "",
              ];

if (isset($_GET["action"])) 
{
    switch ($_GET["action"]) 
    {
        case "check-if-logged": 
        {
            if (isset($_SESSION["user_id"])) 
            {
                $user       = new user($_SESSION["user_id"], $_SESSION["name"], $_SESSION["last_login"]); 
                $rpc_result = [
                                "status"       => true,
                                "name"         => $_SESSION["name"],
                                "last_login"   => $_SESSION["last_login"],
                                "user_id"      => $_SESSION["user_id"],
                              ];
            }
            break;
        }
        case "logout": 
        {
            user::logout();
            break;
        }
    }
}
else 
{
    $req  = file_get_contents("php://input");
    $data = json_decode($req);
    if (isset($data->action))
    {
        switch ($data->action) 
        {
            case "login": 
            {
                $username   = $data->username;
                $password   = $data->password;
                $rpc_result = user::validate_login_data($username, $password);
                if ($rpc_result["status"])
                {
                    $login      = user::login($username, $password);
                    $rpc_result = [
                                    "status"       => ($login)? true:false,
                                    "data"         => ($login)? "user is logged in":"user or password are incorrect",
                                    "name"         => ($login)? $_SESSION["name"]:null,
                                    "last_login"   => ($login)? $_SESSION["last_login"]:null,
                                  ];
                }
                break;
            }
        }
    }
}

die(json_encode($rpc_result));
