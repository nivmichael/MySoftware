<?php

require_once '../autoload.php';
session_start();
// Takes raw data from the request
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$data = json_decode($json);

$action = $_GET['action'] ?? null;
unset($_GET['action']);

if (!$action)
    return http_response_code(400);

switch ($action) {

    case 'editBlog':
        if (!isset($_SESSION["logged_in"])) {
            die("user is not Authorized to perfom this action: " . $action);
        }

        // Check this blog connect to this user that try to perform this action
        $edited_blog = blog::edit_blog($data->blog_id, $data->title, $data->text ,$_SESSION["user_id"]);
        die($edited_blog);
        break;

    case 'deleteBlog':
        if (!isset($_SESSION["logged_in"])) {
            die("user is not Authorized to perfom this action: " . $action);
        }
        
        $deleted = blog::delete_blog($data->blog_id, $_SESSION["user_id"]);
        die($deleted);
        break;

    case 'addBlog':
        if (!isset($_SESSION["logged_in"])) {
            die("user is not Authorized to perfom this action: " . $action);
        }
        $blog = new blog($data->title, $data->text);
        if (!$blog->validate()) {
            die();
        }
        $blog = $blog->createBlog($_SESSION["user_id"]);
        die(json_encode($blog));
        break;

    case 'getBlogs':
        $blogs = blog::get_blogs();
        if (!$blogs) {
            die();
        }
        die(json_encode($blogs));
        break;

    default:
        die;
        break;
}
// V -- CR - add a switch case for action
// V -- Add validation for username & password - if one missing retur error "missing credentials" and show error beneath the login
// V -- Create users table
// V -- Create a login function in user.class.php 
// V -- Validate agains the DB with mysqli 
// V -- Make sure to sanitize the unam and pwd 
