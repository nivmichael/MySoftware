<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Login</title>
  <meta name="description" content="PHP sandbox">
  <meta name="author" content="MMD">

  <link rel="stylesheet" href="styles.css">
    
</head>

<body>
  <div class="container">
    <button class="c-login-button" onclick="openForm()">Login </button>
    <div class="c-form-popup" id="id-loginForm">
    <form class="c-form-container" id="id-form">
        <h2>LOGIN</h2>
        <div>User Name</div>
        <input type="text" id="id-username" placeholder="User Name" ><br>
        <div>Password</div>
        <input type="password" id="id-password" placeholder="Password" ><br> 
        <div id="id-login-status"></div><p>
        <button type="submit" id="id-submit-login" >Login</button>
        <button type="button" onclick="closeForm()">Close</button>
      </form>
    </div>

    <h2>Last task API</h2>
    <div id="id-results" ></div>
    <script src="scripts.js"></script>
  </div>
</body>
</html>