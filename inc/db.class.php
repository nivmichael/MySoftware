<?php 
class db
{
    private $host = "localhost"; 
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
  
    public function query($query) {
      // Prepare and execute SQL query with parameters
      // var_dump($query);

      $ans = $this->conn->query( $query );

      return $ans;
    }
}
