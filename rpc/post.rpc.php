<?php
include "../autoloader.php";
session_start();

$rpc_result = [
                "status" => false,
                "data"   => "Missing action",
              ];
if (isset($_GET["action"])) 
{
    switch ($_GET["action"]) 
    {
        case "all": 
        {
            $rpc_result = post::get_posts();
            break;
        }
        case "posts-by-userid": 
        {
            if (isset($_SESSION["user_id"])) 
            {
                $rpc_result = post::get_posts($_SESSION["user_id"]);
            }
            break;
        }
    }
}
else if (isset($_POST["action"])) 
{
    switch ($_POST["action"]) 
    {
        case "upload-post": 
        {
            $title      = $_POST["title"];
            $body       = $_POST["body"];
            $file_name  = null;
            // Validate text data
            $rpc_result = post::validate_upload_post_text_data($title, $body);
            // Validate img and upload to server
            if ($rpc_result["status"] && isset($_FILES["file"]["name"])) 
            {
                $file_name  = basename($_FILES["file"]["name"]);
                $file_path  = $_FILES["file"]["tmp_name"];
                $rpc_result = post::validate_and_upload_img($file_path);
                if ($rpc_result["status"])
                {
                    $target_dir       = "../uploads/" . $_SESSION["user_id"] . "/";
                    $target_file_path = $target_dir . $file_name;
                    move_uploaded_file($file_path, $target_file_path);
                }
            }
            // Upload img to DB
            if ($rpc_result["status"]) 
            {
                $upload_post = post::upload_post($_SESSION["user_id"],$title,$body,$file_name);
                $rpc_result  = [
                                "status" => ($upload_post)? true:false,
                                "data"   => ($upload_post)? "post uploaded":"upload failed",
                               ];
            }
            break;
        }
        case "edit-title": 
        {
            $id         = $_POST["post-id"];
            $new_title  = $_POST["new-title"];
            if (isset($_SESSION["user_id"])) 
            {
                $post = new post($id);
                $post->edit_title($new_title, $_SESSION["user_id"]);
                $rpc_result  = [
                    "status" => true,
                    "data"   => "post title updated",
                   ];
            }
            break;
        }
        case "delete-post": 
            {
                $id = $_POST["post-id"];
                if (isset($_SESSION["user_id"])) 
                {
                    $post = new post($id);
                    $post->delete_post($_SESSION["user_id"]);
                    $rpc_result  = [
                        "status" => true,
                        "data"   => "post deleted",
                       ];
                }
                break;
            }
    }
}

die(json_encode($rpc_result));