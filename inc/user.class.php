<?php
class user
{
    private $user_id  = null;
    private $username = null;
    private $password     = null;
    const username_length = 3;
    const password_length = 5;

    public function __construct($user_id, $username, $password)
    {
        if (!is_numeric($user_id))
            die('user constractor user_id is not numeric');
        $this->user_id  = $user_id;
        $this->username = $username;
        $this->password = $password;
    }

    public function validate()
    {   
        if (strlen(trim($this->username)) <= user::username_length or strlen(trim($this->password))<= user::password_length) {
            return false;
        }

        return true;
    }

    public function login()
    {  
        $conn = db::connect() or die($conn->error);
        if ($conn->connect_errno) {
            var_dump("connection failed to connect to mysql server");
            exit();
        }
        $username = $conn->real_escape_string($this->username);
        $password = $conn->real_escape_string($this->password);
        $q      = "SELECT username FROM users WHERE username='$username' AND password='$password'";
        $result = $conn->query($q);
        return !!$result->num_rows;
    }
}
