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


                // Initialize post from global variable SESSION with user id, title and body.  
                $post = new post($_SESSION["user_id"], $data->title, $data->body);

                // 4. Save post in DB and assign saved post data
                $post_data = $post->save_post();
                if($post_data) 
                {
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

    case 'get_all_posts': 
        if($post->get_all_posts()) 
         {
            // HTTP Response is 200 By Default
            $response = rpchelper::rpcsuccess('post.rpc.php: getAllPosts() was successful');  
         }
         else 
         {
            // GetAllPosts was not successful => set message into response and return http code 500
            $response = rpchelper::rpcerror('post.rpc.php: getAllPosts() was not successful', 500);  
         }

        break;

    default:
        // Missing action param
        $response = rpchelper::rpcerror('missing action param');
        break;
}

die(json_encode($response));
