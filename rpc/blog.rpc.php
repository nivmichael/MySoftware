<?php

require_once '../autoload.php';
session_start();
// Takes raw data from the request
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$data = json_decode($json);
$res  = null;
$action = $_GET['action'] ?? null;
unset($_GET['action']);

if (!$action)
    return http_response_code(400);

switch ($action) {

    case 'editBlog':
        if (!isset($_SESSION["logged_in"])) {
            die("user is not Authorized to perfom this action: " . $action);
        }

        $blog = new blog($data->text, $data->title, $data->blog_id);
        $edited_blog = $blog->edit_blog($_SESSION["user_id"]);
        $res = $edited_blog;
        break;

    case 'deleteBlog':
        if (!isset($_SESSION["logged_in"])) {
            die("user is not Authorized to perfom this action: " . $action);
        }
        $blog = new blog(null, null, $data->blog_id);
        $res = $blog->delete_blog($_SESSION["user_id"]);
        break;


    case 'addBlog':
  
        if (!isset($_POST["body"])) {
            http_response_code(500);
            die('body paramter is missing in the request');
        }

        if (!isset($_SESSION["logged_in"])) {
            http_response_code(400);
            die("user is not Authorized to perfom this action: " . $action);
        }

        $body = json_decode($_POST["body"]);
        $blog = new blog($body->title, $body->text);
        if (!$blog->validate()) {
            die("blog params are not valid");
        }

        $new_blog = $blog->createBlog($_SESSION["user_id"]);
        $blog_id = (int)$new_blog["id"];

        if (isset($_FILES["file"]) &&  isset($blog_id) ) {
            $file_res = $blog->upload_file($blog_id);
        }

        if(!$file_res["uploaded"]){
            $blog->delete_blog($_SESSION["user_id"]);
            die("file didn't uploaded error: " . $file_res["msg"]);
        }

        $blog->set_id($blog_id);
        $blog->update_file_ext($file_res["file_ext"]);
        $new_blog["file_ext"] = $file_res["file_ext"];
        $res = $new_blog;
        break;

    case 'getBlogs':
        $blog = new blog();
        $blogs = $blog->get_blogs();
        if (!$blogs) {
            $blogs = [];
        }
        $res = $blogs;
        break;

    default:
        break;
}

die(json_encode($res));
