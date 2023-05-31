<?php
class user
{
    private $user_id      = null;
    private $username     = null;
    private $password     = null;
    private $created_at   = null;
    private $last_login   = null;

    public function __construct($user_id = null, $username, $password)
    {
        if ($user_id != null and !is_numeric($user_id))
            die('user constractor user_id is not numeric');
        $this->user_id  = $user_id;
        $this->username = $username;
        $this->password = $password;
    }

    public function validate()
    {
        if (strlen(trim($this->username)) <= config::username_length or strlen(trim($this->password)) <= config::password_length) {
            return false;
        }

        return true;
    }

    public function login()
    {
        $conn = db::connect() or die($conn->error);
        if ($conn->connect_errno) {
            return false;
        }

        $user = $this->find_user($conn);
        if (!$user) {
            return false;
        }
        $this->update_last_login($conn, $user["id"]);
        $this->init_user_session($user["id"], $user["last_login"]);
        return true;
    }

    private function find_user($conn)
    {
        $username = $conn->real_escape_string($this->username);
        $password = $conn->real_escape_string($this->password);
        $q      = "SELECT id, last_login FROM users WHERE username='$username' AND password='$password'";
        $result = $conn->query($q)
            or die("mysql error: find_user()" . $conn->error);
        $res =  $result->fetch_assoc();
        if (!$result->num_rows) {
            return null;
        }
        return $res;
    }

    private function update_last_login($conn, $user_id)
    {
        $sql = "UPDATE users SET last_login = now() WHERE id = '$user_id'";
        $conn->query($sql)
            or die("mysql error: login()" . $conn->error);
    }

    public function init_user_session($id, $last_login)
    {
        $_SESSION["logged_in"]  = true;
        $_SESSION["user_id"]    = $id;
        $_SESSION["username"]   = $this->username;
        $_SESSION["last_login"] = $last_login;
    }

    public static function logout()
    {
        session_unset();
    }
}
