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
        $this->name     = $name;
    }


    public function login($username, $password) {
        //clean string (remove special characters etc..)
        //check if username+password exsists in DB
        //update last_logged_in column for the user
        //begin session
    }

    public function logout() {
        //delete current session
    }
    
}