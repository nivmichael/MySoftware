<?php 
include "../inc/post.class.php";

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
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

?>