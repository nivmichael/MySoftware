<?php
require_once '../mysoftware_autoload.class.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Start new or resume existing session
session_start();

$payload = file_get_contents('php://input');
$data    = json_decode($payload);
$action  = null;
$user_id = null;

if (isset($_GET)) 
{
    $action = $_GET["action"];
}


if (isset($_SESSION["user_id"])) 
{
    $user_id = $_SESSION["user_id"];
}

$response = [
    "status" => false,
    "msg"    => null,
    "data"   => null
];

$post = new post();

switch ($action) {
    case 'create_post': 
            $response["status"] = false;

            if (empty($data->title)) 
            {
                // Title is null or empty so return a error message
                $response = rpchelper::rpcerror('missing title field');
            } else 
            {
                // Title field is OK => set post title and body
                // And call save_post function from post.class.php file
                $post->set_user_id($user_id);
                $post->set_title($data->title);
                isset($data->body) ? $post->set_body($data->body) : $post->set_body("");
        
                $post_data = $post->save_post();
                if ($post_data) {
                    $response = rpchelper::rpcsuccess('saving post was successful');
                    $response["data"] = $post_data;
                } else {
                    // Saving post was not successful
                    // => set message into response and return http code 500
                    $response = rpchelper::rpcerror('saving post was not successful', 500);
                }
            }

        break;

    case 'get_posts':
        $post->set_user_id($user_id);
        $response = rpchelper::rpcsuccess('post.rpc.php: getPosts was successful');
        $response["data"] = $post->get_posts();

        break;

    default:
        // Missing action param
        $response = rpchelper::rpcerror('missing action param');
        break;
}

die(json_encode($response));
