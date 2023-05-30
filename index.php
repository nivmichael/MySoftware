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
  <script src="/libs/nanoajax.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="styles.css?v=1.0">

</head>

<body onload="app.onInit()">

  <div class="c-container">

    <nav class="c-navabar-conatiner">
      <h2><i class="fa-brands fa-blogger-b"></i></h2>
      <input oninput="blog.search(event)" class="c-search-input" type="input" placeholder="Search" />
      <ul class="c-nav-links">
        <li id="id-username-li"></li>
        <li id="id-logout-li" class="c-hide"><button class="c-blog-btn c-white" onclick="user.logout()">Logout</button></li>
      </ul>
    </nav>

    <div class="c-sections-container">

      <section id="id-login-section" class="c-section-container">

        <div class="c-login-title"> Hello to Blog Login! </div>

        <form class="c-form-container" onsubmit="user.loginUser(event)">

          <label for="uname"><b>Username</b></label>
          <input class="c-login-input" type="text" placeholder="Enter Username" name="uname" required>

          <label for="passw"><b>Password</b></label>
          <input class="c-login-input" type="password" placeholder="Enter Password" name="passw" required>

          <button class="c-submit-btn" type="submit">Login</button>

        </form>

        <div id="id-err-login-msg" class="c-err-msg-container"> </div>

      </section>

      <section id="id-blogs-section" class="c-section-container c-hide">

        <div class="c-login-title"> Create your blog! </div>

        <form class="c-form-container" onsubmit="blog.createBlog(event)" method="post" enctype="multipart/form-data">

          <label for="blogtitle"><b>Blog Title</b></label>
          <input class="c-login-input" type="text" placeholder="Enter Title" name="blogtitle" required>

          <label for="blogtext"><b>Blog Text</b></label>
          <input class="c-login-input" type="text" placeholder="Enter Blog Text" name="blogtext" required>

          <div class="c-image-preview-container">
            <label class="c-upload-btn c-blue" for="id-upload-image-input"><b>Upload image</b></label>
            <input onchange="blog.fileChanged(event)" type="file" accept="image/jpeg, image/png, image/jpg" id="id-upload-image-input">
            <span class="c-filename-text" id="id-filename"> </span>
          </div>
          
          <div id="id-image-preview-container" class="c-image-preview-container c-hide">
            <div class="c-image-perview-box">
              <img id="id-image-perview" class="c-image-perview">
            </div>
          </div>

          <button class="c-submit-btn" type="submit">Post</button>
        </form>

        <div id="id-err-blog-msg" class="c-err-msg-container"> </div>
      </section>

      <div id="id-blogs-container" class="c-blogs-container"></div>
    </div>

    <nav id="id-msg-container" class="c-navabar-conatiner c-stick-bottom c-hide">
      <h2><i class="fa-brands fa-blogger-b"></i></h2>
      <ul class="c-nav-links">
        <li><a onclick="user.logout()" href="#">Logout</a></li>
      </ul>
    </nav>
  </div>

  <div id="id-popup-overlay" class="overlay">
    <div id="id-popup-conent" class="popup">

    </div>
  </div>


  <script src="js/config.js"></script>
  <script src="js/user.js"></script>
  <script src="js/app.js"></script>
  <script src="js/blog.js"></script>
  <script src="js/utils.js"></script>


</body>

</html>




<!-- <div class="c-blog-card">
            <div class="c-blog-title">
                Blog Title 1
            </div>
            <div class="c-blog-text">
                Here goes some blog text 1
            </div>
            <div class="c-blog-bottom c-flex-row-center">
                <div class="c-blog-btns">
                    <button class="c-blog-btn c-edit">Edit</button>
                    <button class="c-blog-btn c-delete">Delete</button>
                </div>
                <div class="c-blog-creator">
                    Created By: Shahar92
                </div>
            </div> -->