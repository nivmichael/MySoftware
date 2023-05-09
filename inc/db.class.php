<?php 
class db
{
    private $host     = "localhost"; 
    private $username = "root"; 
    private $password = "12345678"; 
    private $database = "blog"; 
  
    private $conn;
  
    public function __construct() {
      // Establish database connection
      $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
      if ($this->conn->connect_error) {
        die("Connection failed: " . $this->conn->connect_error);
      }

    }

    public function getConn() {
        return $this->conn;
    }
  

    /**
     * Executes a database query
     *
     * @param query string
     * 
     * @return mysqli_result
     */ 
    public function query($query) {
      $ans = $this->conn->query( $query );
      return $ans;
    }


    /**
     * Escapes special characters in a string for use in an SQL statement
     *
     * @param str string
     * 
     * @return string 
     */ 
    public function real_escape_string($str = null) {
      return $this->conn->real_escape_string($str);
   }
}
