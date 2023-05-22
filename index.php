<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>PHP Sandbox</title>
  <meta name="description" content="PHP sandbox">
  <meta name="author" content="MMD">
  <script src="/libs/nanoajax.min.js"></script>

  <link rel="stylesheet" href="styles.css?v=1.0">

</head>

<body>

<form class="form-container" onsubmit="user.loginUser(event)">

<div class="login-container container">

  <label for="uname"><b>Username</b></label>
  <input class="login-input" type="text" placeholder="Enter Username" name="uname" required>

  <label for="passw"><b>Password</b></label>
  <input class="login-input" type="password" placeholder="Enter Password" name="passw" required>

  <button class="submit-btn" type="submit">Login</button>

</div>

</form>


  <script src="js/user.js"></script>

</body>

</html>