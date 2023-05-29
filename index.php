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
<!-- 
  CR:
  Split the index into two section:
  1. our login blog
  2. our blog post form, which show only when we're logged in
  3. Add logouy button in blog section - send rpc to logout and kill session
-->
<body>
  <form id="id-user-login-form" action="/index.php" onsubmit="user.userLogin(event)">
    <label for="username">Username:</label><br>
    <input type="text" id="id-username" name="username"><br>
    <label for="pwd">Password:</label><br>
    <input type="password" id="id-password" name="pwd">
    <input type="submit" id="id-submit-button" value="Submit"> </input>

    <div id="id-message" class="c-message"></div>

  </form>
  <br>
</body>



<script src="js/nanoajax.min.js"></script>
<script src="js/user.js"></script>
<script src="js/userActionsType.js"></script>

</html>