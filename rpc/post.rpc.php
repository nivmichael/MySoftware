<?php 
include "../inc/post.class.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    // var_dump($_SESSION);
    // var_dump($_GET["action"]);

    $result = [];

    if ($_GET["action"] == "all")
    {
        //get posts of all users
        $result = post::get_posts();
    }
    else
    {
        //get posts of current user
        $result = post::get_posts($_SESSION["user_id"]);
    }

    die(json_encode($result));

}


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // var_dump($_POST);
    // var_dump($_SESSION);

    $result = [];

    if ($_POST["action"] == "upload")
    {
        //TODO: continue!!!!
        //TODO: need to get somehow the file_path (so far only got file_name)
        $title = $_POST["title"];
        $body = $_POST["body"];
        $file_name = $_POST["file_name"];

        post::upload_post($title, $body, $_SESSION["user_id"], $file_name);
    }

    //TODO: ADD 2 MORE CONDITIONS: for edit and for delete

    die(json_encode($result));

}

?>