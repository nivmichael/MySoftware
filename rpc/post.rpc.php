<?php
require_once '../mysoftware_autoload.class.php';

// Start new or resume existing session
session_start();

$payload = file_get_contents('php://input');
$data    = json_decode($payload);
$action  = null;

if (isset($_GET)) {
    $action = $_GET["action"];
}

$response = [
    "status" => false,
    "msg"    => null,
    "data"   => null
];

$post = new post();

switch ($action) {
    case 'create_post': 
        {
            $response["status"] = false;
         
            if (empty($data->title))
            {
                // Title is null or empty so return a error message
                $response = rpchelper::rpcerror('missing title field');
            }
            else 
            {
                // Title field is OK => set post title and body
                // And call save_post function from post.class.php file

                // 1. Set post's user id from global variable SESSION
                $post->set_user_id($_SESSION["user_id"]);
                // 2. Set post's title
                $post->set_title($data->title);
                // 3. Set post's body
                $post->set_body($data->body);
                // 4. Save post in DB and assign saved post data
                $post_data = $post->save_post();
                // 5. Assign id from the post data
                $id = $post_data[0];
                if($id) 
                {
                    // Set post id by the returned post data from the DB
                    $post->set_post_id($id)
                        or die("post.rpc.php: set_post_id() id value is incorrect");
                    $response = rpchelper::rpcsuccess('saving post was successful');  
                    $response["data"] = $post_data;
                }
                else 
                {
                    // Saving post was not successful
                    // => set message into response and return http code 500
                    $response = rpchelper::rpcerror('saving post was not successful', 500);  
                }
            }
        }
        break;

    default:
        // Missing action param
        $response = rpchelper::rpcerror('missing action param');
        break;
}

die(json_encode($response));
