<?php 
include "../autoloader.php";

session_start();
header('Content-type: application/json');
$action = isset($_GET['action']) ? $_GET['action'] : null;
$result = array();

switch($action)
{
    case 'all':
        $result = post::get_posts();
        break;

    case 'current-user':
        $result = post::get_posts($_SESSION["user_id"]);
        break;

    case 'upload-post':
        //TODO: continue!!!!
        //TODO: need to get somehow the file_path (so far only got file_name)
        // var_dump($_FILES);

        $title = $_POST["title"];
        $body = $_POST["body"];
        $file_name = $_FILES["file"]["name"];
        $file_path = $_FILES["file"]["tmp_name"];

        post::upload_post($title, $body, $_SESSION["user_id"], $file_path);

        break;

    default:
        die(json_encode(['error'=>'user.rpc: missing action param']));
    
    //TODO: ADD 2 MORE CONDITIONS: for edit and for delete

}

die(json_encode($result));


?>