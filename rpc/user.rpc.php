<?php
// Start session
//session_start();

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
    
    var_dump($_REQUEST);die;
}
?>