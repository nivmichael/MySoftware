<?php
class db
{
    private static $conn = null;
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "blog";
    
    /**
     * Default constructor for db connection

     * @return mysqli with db connection
     */ 
    public function __construct() {
        if (!self::$conn) {
            self::$conn = new mysqli($this->host, $this->username, $this->password, $this->db);
            if (self::$conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }
        return self::$conn;
    }  

    /**
     * Executes a database query
     *
     * @param query string
     * 
     * @return mysqli_result
     */ 
    function query($query) {
		return self::$conn->query( $query );
	}

    /**
     * Closes the database connection
     */ 
	function close() {
		self::$conn->close();
        self::$conn = null;
	}

    /**
     * Escapes special characters in a string for use in an SQL statement
     *
     * @param str string
     * 
     * @return string 
     */ 
    public function real_escape_string($str = null) {
       return self::$conn->real_escape_string($str);
    }
}