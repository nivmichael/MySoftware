<?php 
class login
{
    private $username = null;
    private $password = null;

    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }
    
}