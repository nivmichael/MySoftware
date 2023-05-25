<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>PHP Sandbox</title>
  <meta name="descrption" content="PHP sandbox">
  <meta name="authori" content="MMD">
  <link rel="stylesheet" href="styles.css?v=1.0">

  </head>

  <body>
  <form id="id-user-login-form" onsubmit="user.userLogin(event)">
  <label for="username">Username:</label><br>
  <input type="text" id="username" name="username" required="true"><br>
  <label for="pwd">Password:</label><br>
  <input type="password" id="pwd" name="pwd">
  <input type="submit" id="submitButton" value="Submit"> </input> 

</form>
<br>
</body>



  <script src="js/nanoajax.min.js"></script>
  <script src="js/user.js"></script>
  <script src="js/consts.js"></script>
  <script src="js/userActionsType.js"></script>
</html>