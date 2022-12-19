<?php 
class user
{
    private $user_id  = null;
    private $username = null;
    private $name     = null;
    private $last_login = null;

    /**
     * constructs user with user_id, name, last_login
     *
     * @param user_id int
     * @param name string
     * @param last_login date
     * 
     * @return user
     */ 
    public function __construct($user_id, $name, $last_login)
    {
        if(!is_numeric($user_id))
            die("user constractor user_id is not numeric");
        $this->user_id      =   $user_id;
        $this->name         =   $name;
        $this->last_login   =   $last_login;
    }

    /**
     * check if user exits in db by credentials - and set the session with uid, name and last_login
     *
     * @param username string
     * @param password string
     * 
     * @return boolean true/false if success/fail
     */ 
    public static function login($username, $password) 
    {
        $conn               = new db();
        $sanitized_username = $conn->real_escape_string($username);
        $sanitized_password = $conn->real_escape_string($password);
        $sql                = "SELECT * 
                               FROM users 
                               WHERE username = '$sanitized_username' 
                               AND   password = '$sanitized_password'";
        $result             = $conn->query($sql)
                                or die("Error in user::login $conn->error");
        $row                = $result->fetch_assoc();
        $result->free();

        // If user not exist
        if (!$row)
        {
            return false;
        }

        // If user exist Update users last login
        $id                 = $row["id"];
        $sql                = "UPDATE users 
                               SET last_login = NOW() 
                               WHERE id = $id";
        $conn->query($sql)
            or die("Error in user::login $conn->error");

        
        // Update sessions
        $_SESSION["login"]      = TRUE;
        $_SESSION["user_id"]    = $row["id"];
        $_SESSION["name"]       = $row["name"];
        $_SESSION["last_login"] = $row["last_login"];

        return true;
    }

    /**
     * Logout user by unset session
     */ 
    public static function logout() 
    {
        session_unset();
    }

    /**
     * Validates that username,password exist, username is valid email
     *
     * @param username string
     * @param password string
     * 
     * @return array("status"=>boolean, "data"=>string)
     */ 
    public static function validate_login_data($username, $password) 
    {
        $result = [
                    "status" => true,
                    "data"   => "",
                  ];
        // Validator that username exist
        if (!$username) 
        {
            $result["status"] = false;
            $result["data"]  .= "username is required"."</br>";
        }
        // Validator that username is an email
        else if (!filter_var($username, FILTER_VALIDATE_EMAIL)) 
        {
            $result["status"] = false;
            $result["data"]  .= "username is not valid (should be an email)"."</br>";
        }
        // Validator that password exist
        if (!$password) 
        {
            $result["status"] = false;
            $result["data"]  .= "password is required"."</br>";
        }
        return $result;
    }
}