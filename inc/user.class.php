<?php
class user
{
    private $username   = null;
    private $password   = null;

    public function __construct($username = null, $password = null)
    {
        if(!$this->username) {
            $this->username = $username;
            $this->password = $password; 
        }
    }

    public function init_session($id)
    {
        $_SESSION["user_id"] = $id;
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
