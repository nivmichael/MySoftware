<?php
class user
{
    private $id         = null;
    private $username   = null;
    private $password   = null;
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
        if(is_numeric($id))
        {
            $this->id = $id;
        }
        return $this->id;
    }

    public function set_username($username)
    {
        $this->username = $username;
    }

    public function set_password($password)
    {
        $this->password = $password;
    }

    public function set_last_login($last_login)
    {
        $this->last_login = $last_login;
    }

    public function init_session()
    {
        $_SESSION["user_id"] =$this->id;
    }

    public function login()
    {
        $data = [];
        $response = null;
        // Connect to DB          
        $mysqli     = db::connect();
        $password = $mysqli->real_escape_string(trim(strip_tags($this->password)));
        $username = $mysqli->real_escape_string(trim(strip_tags($this->username)));

        // Executes sql statement to get user from users table by username and password     
        $sql = "SELECT id, 
        username, 
        password 
        FROM users 
        WHERE username = '$username' 
        AND password = '$password'";

        $res = $mysqli->query($sql) 
            or die("Mysql error: login()" . $mysqli->error);
        // Gets the Sql row from res
        $data = $res->fetch_row();
        // checks if $data[0] is not null => sets response with id
        if(isset($data[0])) 
        {
            $response = $data[0];

            // Update users table with last_login value to DB
            $sql = "UPDATE users 
            SET last_login = NOW()
            WHERE id = $data[0]";

            $res = $mysqli->query($sql) 
                or die("Mysql error: login()" . $mysqli->error);
        }

        return $response;
    }

    public function logout()
    {
        return session_destroy();
    }
}
