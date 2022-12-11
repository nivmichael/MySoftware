<?php
include "../autoloader.php";

$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $req = file_get_contents('php://input');
    $data = json_decode($req);
    $username = $data->{"username"};
    $password = $data->{"password"};
    
    // Validator that username exist
    if (!$username) {
        die(json_encode([
            'login' => false,
            'data' => 'username is required',
          ]));
    }
    // Validator that username is an email
    else if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        die(json_encode([
            'status' => false,
            'data' => 'username is not valid (should be an email)',
          ]));
    }
    // Validator that password exist
    else if (!$password) {
        die(json_encode([
            'status' => false,
            'data' => 'password is required',
          ]));
    }
    // If all params (user,password) are ok
    else {
        echo (json_encode([
            'status' => true,
            'data' => 'all params are ok',
          ]));
    }

    //db connect and select all users query
    $conn = new db();
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $usersArray = [];
    while($row = mysqli_fetch_array($result))
    {
        $usersArray[] = $row;
    }
    $conn->close();
}

die;
?>