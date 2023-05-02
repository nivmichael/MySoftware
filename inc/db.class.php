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
      try {
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
    }

    public function getConn() {
        return $this->conn;
    }
  
    public function query($sql, $params = []) {

      // Prepare and execute SQL query with parameters
      try {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
      } catch(PDOException $e) {
        echo "Query failed: " . $e->getMessage();
      }
    }
}



/* TO USE THE DATABASE:::

$db = new Database();

// Example query
$sql = "SELECT * FROM users WHERE username = ?";
$username = "john";
$stmt = $db->query($sql, [$username]);

// Loop through result set
while ($row = $stmt->fetch()) {
  echo $row["username"] . "<br>";
}


*/