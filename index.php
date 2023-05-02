
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

<body>
  <button id="loginBtn">Login</button>
  <br>
  <br>

  <!-- Login popup -->
  <!-- 
    id -> we always use "id-...." to name id's, and only - as separetors 
    so loginPopup should be id-login-popup
    same in classes: c-some-class-name

    remove action - use ajax (js function to submit the form)
   -->
  <div id="loginPopup">
    <form action="rpc/user.rpc.php" method="post">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
      <br>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
      <br>
      <input type="submit" value="Login">
    </form>
  </div>
  <details>
    <summary>Details</summary>
    Something small enough to escape casual notice.
</details>

  <div id="results" class="container">

  </div>
  <script src="scripts.js"></script>
</body>
</html>
