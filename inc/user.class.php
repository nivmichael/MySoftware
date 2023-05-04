<?php 
include 'db.class.php';

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
        $this->name     = $name;
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

        return $result;
        
    }
    
}