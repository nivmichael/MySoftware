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
    
}