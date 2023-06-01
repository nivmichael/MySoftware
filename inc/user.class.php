<?php
class user
{
    private $id       = null;
    private $username = null;
    private $password = null;
    private $last_login = null;

    public function __construct($username = null, $password = null, $id = null)
    {
        if(!$this->id) {
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
        $response = null;

        $conn     = db::connect();
        $password = $conn->real_escape_string(trim(strip_tags($this->password)));
        $username = $conn->real_escape_string(trim(strip_tags($this->username)));

        // Executes sql statement to get user from users table by username and password     
        $sql = "SELECT id, 
        username, 
        password 
        FROM users 
        WHERE username='$username' 
        AND password='$password'";

        $res = $conn->query($sql) 
            or die("Mysql error: login()" . $conn->error);
        // Gets the Sql row from res
        $data = $res->fetch_row();
        // checks if $data[0] is not set or null => return false 
        if(!isset($data[0])) {
            $response = $data[0];
        }

        return $response;
    }

    public function logout()
    {
        return session_destroy();
    }
}
