<?php 
class user
{
    private $user_id  = null;
    private $username = null;
    private $name     = null;
    private $last_login = null;

    public function __construct($user_id, $name, $last_login)
    {
        if(!is_numeric($user_id))
            die('user constractor user_id is not numeric');
        $this->user_id      =   $user_id;
        $this->name         =   $name;
        $this->last_login   =   $last_login;
    }

    /**
     * check if user exits in db by credentials - and set the session with uid, name and last_login
     *
     * @param username
     * @param password
     * 
     * @return true/false if success/fail
     */ 
    public static function login($username, $password) 
    {
        // DB connect and query if user exist
        $conn = new db();
        $sanitized_username = $conn->real_escape_string($username);
        $sanitized_password = $conn->real_escape_string($password);
        $sql = "SELECT * FROM users WHERE username = '$sanitized_username' AND password = '$sanitized_password'";
        $result = $conn->query($sql);
        if($row = mysqli_fetch_assoc($result))
        {
            $result = $row;
        }
        // If user not exist
        if (!$row) {
            $conn->close();
            return false;
        }

        // If user exist
        // Update users last login
        $id = $result["id"];
        $sql = "UPDATE users SET last_login = now() WHERE id = $id";
        $conn->query($sql);
        $conn->close();
        
        // Update sessions
        $_SESSION["login"] = TRUE;
        $_SESSION["user_id"] = $result["id"];
        $_SESSION["name"] = $result["name"];
        $_SESSION["last_login"] = $result["last_login"];

        return true;
    }


    public static function logout() 
    {
        //session_unset();
    }
}