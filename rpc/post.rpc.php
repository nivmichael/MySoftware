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

        $title      = $_POST["title"];
        $body       = $_POST["body"];

        $new_filepath = null;

        if ($_FILES["file"])
        {
            $new_filepath = post::upload_file($_SESSION["user_id"]);
        }

        post::upload_post($title, $body, $_SESSION["user_id"], $new_filepath);

        break;

    
    case 'delete-post':

        $post_id = $_POST["post_id"];
        post::delete_post($post_id);

        break;


    case 'update-post':
        // var_dump($_POST);
        $post_id = $_POST["post_id"];
        $title   = $_POST["title"];
        post::update_post($post_id, $title);

        break;

    default:
        die(json_encode(['error'=>'user.rpc: missing action param']));
    
    //TODO: ADD 2 MORE CONDITIONS: for edit and for delete

}

die(json_encode($result));


?>