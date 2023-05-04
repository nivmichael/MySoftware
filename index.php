<?php
  session_start();
?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>PHP Sandbox</title>
  <meta name="description" content="PHP sandbox">
  <meta name="author" content="MMD">

  <link rel="stylesheet" href="styles.css">
  

  <script type="text/javascript" src="js/nanoajax.min.js"></script>
  
    
</head>

<body onload="checkUserLogged();">
  <button id="id-login-btn">Login</button>
  <br>
  <br>

  <!-- Login popup -->
  <div id="id-login-popup">
    <form method="post">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
      <br>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
      <br>
      <input type="button" value="Login" onClick="loginClicked()">
      <input type="button" value="Cancel" onClick="cancelClicked()">
    </form>
  </div>

  <div id="id-user-logged-in"> 
    <p id="user-logged-in-text"> user is logged in now! </p>
    <button id="id-logout-btn">Logout</button>
  </div>
  
  <div id="id-results" class="c-container">

  </div>
  <script src="scripts.js"></script>
</body>
</html>
