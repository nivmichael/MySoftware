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
        // var_dump($_POST);

        $title = $_POST["title"];
        $body = $_POST["body"];

        $new_filepath = null;

        if ($_FILES["file"])
        {
            $new_filepath = post::upload_file($_SESSION["user_id"]);
        }

        post::upload_post($title, $body, $_SESSION["user_id"], $new_filepath);

        break;

    default:
        die(json_encode(['error'=>'user.rpc: missing action param']));
    
    //TODO: ADD 2 MORE CONDITIONS: for edit and for delete

}

die(json_encode($result));


?>