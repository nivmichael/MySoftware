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


  <section id="id-login-section">
    <div>
      <form id="id-user-login-form" action="/index.php" onsubmit="user.userLogin(event)">
        <label for="username">Username:</label><br>
        <input type="text" id="id-username" name="username"><br>
        <label for="pwd">Password:</label><br>
        <input type="password" id="id-password" name="pwd">
        <input type="submit" id="id-submit-button" value="Submit"> </input>

        <div id="id-message-login" class="c-message"></div>
    </div>
    </div>

    </form>
  </section>

  <section id="id-create-blog-section" class="c-hide-content">
    <button class="c-button-log-out" id="id-logout-button" type="button" onclick="user.userLogout(event)">Log Out</button>
    <h2 class="c-blog-form-title">Blog Form</h2>
    <textarea class="c-text-area" id="id-blog-form" name="form" rows="4" cols="50"></textarea>
    <div id="id-message-create-blog" class="c-message"></div>

  </section>

</body>

<script src="js/nanoajax.min.js"></script>
<script src="js/config.js"></script>
<script src="js/user.js"></script>
<script src="js/app.js"></script>

</html>