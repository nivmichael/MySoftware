<?php 
class user
{
    public $user_id  = null;
    private $username = null;
    private $password = null;
    public $name     = null;
    public $last_login = null;

    // public function __construct($username, $password)
    // {
    //     $user = $this->user_exist($username,$password);
    //     if (!$user) {
    //         die(json_encode([
    //             'status' => false,
    //             'data' => 'user or password are incorrect',
    //             ]));
    //     }
    //     $this->user_id  = $user["id"];
    //     $this->username = $user["username"];
    //     $this->password = $user["password"];
    //     $this->name     = $user["name"];
    //     $this->last_login = $user["last_login"];
    // }

    /**
     * check if user exits in db by credentials - and set the session with uid, name and last_login
     *
     * @param username
     * @param password
     * 
     * @return true/false if success/fail
     */ 
    public static function login($username, $password) {
        // Sanitize params
        $sanitized_username = filter_var($username, FILTER_SANITIZE_EMAIL);
        $sanitized_password = filter_var($password, FILTER_SANITIZE_STRING);

        // DB connect and query if user exist
        $conn = new db();
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
        
        //session_start();
        $_SESSION["login"] = TRUE;
        $_SESSION["user_id"] = $result["id"];
        $_SESSION["name"] = $result["name"];
        $_SESSION["last_login"] = $result["last_login"];

        return true;
    }
}