<?php
include "../inc/user.class.php";



// Check if form has been submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") 
// {
//   // Get username and password from form
//   $username = $_POST["username"];
//   $password = $_POST["password"];

//   // Validate login credentials (replace with your own validation code)
//   if ($username == "admin" && $password == "password") 
//   {
//     // Login successful, redirect user to homepage
//     $_SESSION["username"] = $username;
//     // header("Location: ../index.php");
//     // exit;
//     echo "Logged in succesfully";
//   } 
//   else 
//   {
//     // Login failed, display error message
//     $errorMessage = "Invalid username or password.";

//     echo $errorMessage;
//   }
// }


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

    $username = $_POST["username"];
    $password = $_POST["password"];

    //clean string (remove special characters etc..)
    //check if username if valid email
    //create new user and call login function on it

    if (!$username) 
    {
        http_response_code(404);
        die("should provide username!");
    }
    if (!filter_var($username, FILTER_VALIDATE_EMAIL))
    {
        http_response_code(404);
        die("username should be an email!");
    }
    if (!$password) 
    {
        http_response_code(404);
        die("should provide password!");
    }

    $logged_in = user::login($username, $password);

    if ($logged_in) 
    {
        // Start session
        session_start();
        
        var_dump($_REQUEST); die;
    }
    else
    {
        http_response_code(404);
        die("no user in DB with username and password!");
    }
}
?>