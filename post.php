<h2>Welcome <?php echo $_SESSION['name'] ?> !</h2>
<div>Last Login: <?php echo $_SESSION['last_login'] ?> </div>
<p>
<div class="c-upload-container">
    <form id="id-upload-post-form">
        <h3>Upload Post</h3>

        <div>Post Title</div>
        <input type="text" id="id-post-title" name="title" placeholder="Title" maxlength="100">

        <div>Post Body</div>
        <textarea id="id-post-body" name="body" placeholder="Body" rows="10"></textarea>

        <div>Upload Image</div>
        <input type="file" id="id-post-file" name="file">
        <p></p>

        <input type="submit" class="c-post-submit" name="post-submit" value="Upload Post">
    </form>
</div>
