<?php
session_start();
?>

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

<body onload="init(event)">

  <section id="id-login-section" class="c-hide-content">
    <div id="id-login-div">
      <form id="id-user-login-form" class="c-login-form" action="/index.php" onsubmit="user.userLogin(event)">
        <label for="username">Username:</label><br>
        <input id="id-username" type="text" name="username" required="true"><br>
        <label for="pwd">Password:</label><br>
        <input id="id-password" type="password" name="pwd" required="true" />
        <input id="id-submit-button" type="submit" value="Submit" />

        <div id="id-message-login" class="c-message"></div>
      </form>

    </div>
  </section>


  <section id="id-create-blog-section" class="c-hide-content">
    <button id="id-logout-button" class="c-button-log-out" type="button" onclick="user.userLogout(event)">Log Out</button>
    <div id="id-post-div">
      <form id="id-create-blog-form" class="c-post-form" method="post" action="/index.php" onsubmit="post.createPost(event)">
        <h2 class="c-blog-form-title">Blog Form</h2>
        <input id="id-post-title-form" class="c-post-form-input" type="text" name="title" placeholder="Type here your title..." /><br>
        <textarea id="id-post-body-form" class="c-post-form-input" name="body" placeholder="What's on your mind?" rows="4" cols="50"></textarea>
        <input id="id-image-file" type="file" name="filename" accept="image/*" enctype="multipart/form-data" />
        <input id="id-submit-post-button" class="c-button-post-button" type="submit" value="Post" />

        <div id="id-message-create-blog" class="c-message"></div>
      </form>

    </div>

  </section>
  <div id="id-posts" class="c-container"></div>

</body>

<script src="js/nanoajax.min.js"></script>
<script src="js/config.js"></script>
<script src="js/post.js"></script>
<script src="js/user.js"></script>
<script src="js/app.js"></script>

<script>
  function init(event) {
    event.preventDefault();

    const callbackFn = (loggedIn) => {
      let currSection = loggedIn ? SECTION.login : SECTION.createBlog;
      switch (currSection) {
        case SECTION.login:
          app.displaySection(SECTION.createBlog, currSection);
          break;
        case SECTION.createBlog:
          app.displaySection(SECTION.login, currSection);
          break;
      }
      post.getAllPosts(loggedIn);
    }
    user.isLogin(callbackFn)
  }
</script>

</html>