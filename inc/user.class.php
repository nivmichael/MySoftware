<?php
class user
{
    private $id = null;
    private $username = null;
    private $password = null;
    private $last_login = null;

    public function __construct($username = null, $password = null, $id = null)
    {
        if($this->id == null) {
            $this->id       = $id;
            $this->username = $username;
            $this->password = $password; 
        }
    }

    public function set_id($id)
    {
        if(!is_numeric($id))
        {
            $this->id = $id;
        }
    }

    public function set_username($username)
    {
        $this->username = $username;
    }

    public function set_password($password)
    {
        $this->password = $password;
    }

    public function get_username()
    {
        return $this->username;
    }

    public function get_password()
    {
        return $this->password;
    }

    public function init_session()
    {
        $_SESSION = [
            "user_id" => $this->id,
        ];
    }

    public function login()
    {
        $data = [];

        $conn     = db::connect();
        $password = $conn->real_escape_string(trim(strip_tags($this->password)));
        $username = $conn->real_escape_string(trim(strip_tags($this->username)));

        // Checks if username exists with username and password.        
        $sql = "SELECT id, 
        username, 
        password 
        FROM users 
        WHERE username='$username' 
        AND password='$password'";

        $res = $conn->query($sql) 
        or die("Mysql error: login()" . $conn->error);
    
        $data = $res->fetch_row();

        if(!isset($data)) {
            return false;
        }

        return $data[0];
    }

    public function logout()
    {
        return session_destroy();
    }
}
