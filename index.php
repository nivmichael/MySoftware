<?php
session_start();
print_r($_SESSION);
?>

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

<body onload="getAllPosts();userLogged()">
  <div class="c-container">
    <div id="id-header">
    <div id="id-user-data">
      <h2 id="id-user-data-h2"></h2>
      <h5 id="id-user-data-h5"></h5>
    </div>
    
    <div id="id-navigation">
      <button class='c-login-button' id='id-login-button' onclick='openForm()'>Login </button>
      <div class="c-login-popup" id="id-login-popup">
        <form class="c-form-container" id="id-login-form">
          <h2>Login</h2>
          <div>User Name</div>
          <input type="text" id="id-username" placeholder="User Name" ><br>
          <div>Password</div>
          <input type="password" id="id-password" placeholder="Password" ><br> 
          <div id="id-login-status"></div><p>
          <button type="submit" id="id-submit-login">Login</button>
          <button type="button" onclick="closeForm()">Close</button>
        </form>
      </div>
      <button class='c-logout-button' id='id-logout-button' onclick='userLogout()'>Logout </button>
    </div>
    </div>
    <div id="id-posts">
      <div class="c-upload-container" id="id-post-upload">
        <?php
        include('post.php');
        ?>
      </div>
      <div id="id-filter-posts">
        <input type="text" id="id-filter-by-name" onkeyup="filterPostsByNameFunc()" placeholder="Search posts by user's name">
      </div>
      <div id="id-all-posts">
        <div class="c-blog-container" id="id-blog-container"></div>
      </div>
    </div>
    <div id="id-api-results">
      <h2>Last task API</h2>
      <div id="id-results" ></div>
    </div>
    <script src="scripts.js"></script>
  </div>
</body>
</html>