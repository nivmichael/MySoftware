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
            $title = $_POST["title"];
            $body = $_POST["body"];
            $file_path = null;
            // Text validations
            $rpc_result = validate_upload_post_text($title, $body);
            //  File validations and upload to server
            if (isset($_FILES["file"]["name"])) 
            {
                $rpc_result = validate_and_upload_img();
            }
            // Upload to DB
            if ($rpc_result["status"]) 
            {
                $upload_post = post::upload_post($_SESSION["user_id"],$title,$body,$file_path);
                $rpc_result = [
                    "status" => ($upload_post)? true:false,
                    "data"   => ($upload_post)? "post uploaded":"upload failed",
                ];
            }
            break;
        }
    }
}

function validate_upload_post_text($title, $body) 
{
    $result = [
        "status" => true,
        "data"   => "",
      ];
    // Validator that title exist
    if (!$title) {
        $result["status"] = false;
        $result["data"] .= "Title is required"."</br>";
    }
    // Validator that body exist
    if (!$body) {
        $result["status"] = false;
        $result["data"] .= "Body is required"."</br>";
    }
    return $result;
}

function validate_and_upload_img()
{
    $result = [
        "status" => true,
        "data"   => "",
      ];

    $target_dir = "../uploads/" . $_SESSION["user_id"] . "/";
    $file_name = basename($_FILES["file"]["name"]);
    $target_file_path = $target_dir . $file_name;
    $file_path = $_FILES["file"]["tmp_name"];
    $file_size = filesize($file_path);
    $file_info = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($file_info, $file_path);
    $allowed_types = [
       "image/png" => "png",
       "image/jpeg" => "jpg",
       "image/gif" => "gif",
    ];
    if ($file_size === 0) {
        $result["status"] = false;
        $result["data"] .= "The file is empty"."</br>";
    }
    else if ($file_size > 3145728) { // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))
        $result["status"] = false;
        $result["data"] .= "The file is too big"."</br>";

    }
    else if (!in_array($file_type, array_keys($allowed_types))) {
        $result["status"] = false;
        $result["data"] .= "File type not allowed"."</br>";
    }
    else {
        // Create root with user"s folder if doesn"t exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        // Upload file to server
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file_path);
        $result["status"] = true;
        $result["data"] .= "img uploaded"."</br>";
    }
    return $result;
}

die(json_encode($rpc_result));