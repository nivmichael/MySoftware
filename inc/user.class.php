<?php
class user
{
    private $id = null;
    private $username = null;
    private $password = null;
    private $last_login = null;


    public function __construct($username, $password, $id = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->id       = $id;
    }

    public function set_id($id)
    {
        $this->id       = $id;
    }

    public function init_session()
    {
        $_SESSION = [
            "user_id" => $this->id,
        ];
    }

    // CR: sanitize strings, trim, strip tags
    // For numeric we use is_numeric
    public function login()
    {
        $conn = db::connect();
        $password = $conn->real_escape_string($this->password);
        $username = $conn->real_escape_string($this->username);

        // Checks if username exists with username and password.        
        $sql = "SELECT id,username,password FROM users WHERE username='$username' AND password='$password'";

        $res = $conn->query($sql) or die($conn->error);
        $data = $res->fetch_row();
        // Sets the id from SQL Database
        $this->set_id($data[0]);

        return $res->num_rows > 0;
    }

    public function logout()
    {
        return  session_destroy();

    }
}
