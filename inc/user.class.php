<?php 

class user
{
    private $user_id  = null;
    private $username = null;
    private $type     = null;

    public function __construct($user_id, $username, $name, $type)
    {
        if(!is_numeric($user_id))
            die('user constractor user_id is not numeric');
        $this->user_id  = $user_id;
        $this->username = $username;
        $this->type     = $type;
    }


    public static function check_logged_in()
    {
        // var_dump('in checked logged in');

        $result = [];

        if (isset($_SESSION["user_id"])) 
        { 
            $result = 
            [
                "status" => true,
                "user_id" => $_SESSION["user_id"],
                "username" => $_SESSION["username"],
                "prev_login" => $_SESSION["prev_login"]
            ];

            
        }
        else
        {
            $result = 
            [
                "status" => false
            ];

        }

        

        return $result;
    } 


    public static function login($username, $password) 
    {
        $result = 
        [
            "status" => false,
            "user" => []
        ];

        $db = new db();
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

        $stml = $db->query($query);

        $row = $stml->fetch_assoc();

        if (!$row) 
        {
            return $result;
        }

        $id = $row["id"];

        $prev_login = $row["last_login"];

        // $time_since_last_login = strtotime("now") - strtotime($last_login); 
        
        $query = "UPDATE users  SET last_login = NOW()  WHERE id = $id";

        $db->query($query);

        $result["status"] = true;
        $result["user"] = 
        [
            "id" => $row["id"],
            "username" => $row["username"],
            "prev_login" => $prev_login
        ];

        $user = $result["user"];
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["prev_login"] = $user["prev_login"];

        return $result;
        
    }


    public static function logout()
    {
        session_unset();
    } 


    public static function validate_params($username, $password)
    {
        $rv = ["status" => true, "error" => ""];

        if (!$username) 
        {
            $rv["status"] = false;
            $rv["error"] = "should provide username!";
        }
        if (!filter_var($username, FILTER_VALIDATE_EMAIL))
        {
            $rv["status"] = false;
            $rv["error"] = "username should be an email!";
        }
        if (!$password) 
        {
            $rv["status"] = false;
            $rv["error"] = "should provide password!";
        }

        return $rv;
    } 
    
}