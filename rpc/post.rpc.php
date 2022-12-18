<?php
include "../autoloader.php";
session_start();

$rpc_result = [];
if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
    if (isset($_GET['action'])) {
        switch ($_GET['action']) 
        {
            case "all": 
            {
                $return_arr = array();
                $conn = new db();
                $sql = "SELECT posts.*,users.name FROM posts JOIN users ON posts.user_id = users.id ORDER BY id DESC";
                $result = $conn->query($sql);
                while($row = mysqli_fetch_array($result)){
                    $rpc_result[] = array("id" => $row['id'],
                                    "user_id" => $row['user_id'],
                                    "name" => $row['name'],
                                    "title" => $row['title'],
                                    "body" => $row['body'],
                                    "file_path" => $row['file_path'],
                                    "uploaded_on" => $row['uploaded_on']);
                }
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (isset($_POST['action'])) {
        switch ($_POST['action']) 
        {
            case "upload-post": 
            {
                $title = $_POST['title'];
                $body = $_POST['body'];
                $file_path = null;

                // Text validations
                $rpc_result = validate_upload_post_text($rpc_result, $title, $body);

                //  File validations and upload
                if (isset($_FILES["file"]["name"])) {
                    $targetDir = "../uploads/" . $_SESSION["user_id"] . "/";
                    $file_path = basename($_FILES["file"]["name"]);
                    $targetFilePath = $targetDir . $file_path;
                    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                    $allowTypes = array('jpg','png','jpeg','gif','pdf');
                    if(in_array($fileType, $allowTypes)){
                        // If sub-folder for user uploads doesnt exist creats one
                        if (!is_dir($targetDir)) {
                            mkdir($targetDir, 0777, true);
                        }
                        // Upload file to server
                        move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
                    }
                }

                //upload to db
                if (!isset($rpc_result['status']) || $rpc_result['status'] !== false) {
                    $upload_post = post::upload_post($_SESSION["user_id"],$title,$body,$file_path);
                    $rpc_result = [
                        'status' => ($upload_post)? true:false,
                        'data' => ($upload_post)? 'post uploaded':'upload failed',
                    ];
                }
            }
        }
    } else {
        $rpc_result = [
            'status' => false,
            'data' => 'missing action',
            ];
    }
}

function validate_upload_post_text($rpc_result, $title, $body) 
{
    // Validator that title exist
    if (!$title) {
        $rpc_result = [
            'status' => false,
            'data' => 'title is required',
          ];
    }
    // Validator that body exist
    else if (!$body) {
        $rpc_result = [
            'status' => false,
            'data' => 'body is required',
          ];
    }
    // Validators for file
    /********** */
    return $rpc_result;
}

die(json_encode($rpc_result));