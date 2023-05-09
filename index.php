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

  <input type="text" id="id-search-text" placeholder="search for post title" oninput="searchTextChanged()" >

  <br>
  <br>

  <!-- Login popup -->
  <div id="id-login-popup" class="c-popup-form">
    <form method="post">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
      <br>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
      <br>
      <br>
      <p id="id-login-error-msg" class="c-error-msg">  </p>
      <input type="button" id="id-confirm-login-btn" value="Login" onClick="loginClicked()">
      <input type="button" value="Cancel" onClick="cancelLoginClicked()">
    </form>
  </div>

  <div id="id-user-logged-in"> 
    <p id="id-user-logged-in-text"> user is logged in now! </p>
    <p id="id-success-message">  </p>

    <br>
    <br>

    <button id="id-upload-post-btn">Create Post</button>
      <br>
      <br>

    <div id="id-upload-post-form" class="c-popup-form">

      <form method="post" enctype="multipart/form-data">
        <label for="id-post-title">Title:</label>
        <input type="text" id="id-post-title" name="id-post-title" required>
        <br>
        <label for="id-post-body">Body:</label>
        <textarea id="id-post-body" name="id-post-body" required></textarea>
        <br>
        Select image to upload:
        <input type="file" name="fileToUpload" id="id-file-to-upload">
        <br>
        <br>
        <p id="id-file-error-msg" class="c-error-msg">  </p>
        <input type="button" value="Upload Post" onClick="uploadPost()">
        <input type="button" value="Cancel" onClick="cancelUploadPostClicked()">
      </form>
    </div>


    <div id="id-edit-post-form" class="c-popup-form">

      <form method="post">
        <label for="id-post-title">Title:</label>
        <input type="text" id="id-edit-post-title" name="id-post-title" required>
        <br>
        <input type="button" value="Update Post" onClick="updatePost()">
        <input type="button" value="Cancel" onClick="cancelEditPostClicked()">
      </form>
    </div>

    <button id="id-logout-btn">Logout</button>
  </div>
  
  <div id="id-results" class="c-container">

  </div>
  <script src="scripts.js"></script>
</body>
</html>
