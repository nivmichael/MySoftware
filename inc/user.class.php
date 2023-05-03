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
        //check if username+password exsists in DB
        $db = new db();
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

        $stml = $db->query($query);

        $row = $stml->fetch_assoc();

        if (!$row) 
        {
            return false;
        }

        $id = $row["id"];

        $query = "UPDATE users  SET last_login = NOW()  WHERE id = $id";

        return true;
        
    }

    public function logout() 
    {
        //delete current session
    }
    
}