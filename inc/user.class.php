<?php 
class user
{
    private $username = null;
    private $password = null;

    public function __construct($username,$password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function login() {
        // Checks if username exists with username and password.        
        $sql = "SELECT username,password FROM users WHERE username='$this->username' AND password='$this->password';";
        $res =db::connect()->query($sql) or die(db::connect()->error);

        if (db::connect()->connect_errno) {
            var_dump("conn error");
        }
        if($res->num_rows>0){
            // If user exists in Database return 200
            $response = ['success'=>'user login was successful'];
            http_response_code(200);
        }
        else{
            $response = ['unsuccessful'=>'user login was not successful'];
            http_response_code(404);
        }
      
        return $response;
    }
}