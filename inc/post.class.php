<?php 
class post
{
    public static function upload_post($user_id, $title, $body, $file_path = null) 
    {
        // DB connect and query post upload
        $conn = new db();
        $sanitized_title = $conn->real_escape_string($title);
        $sanitized_body = $conn->real_escape_string($body);
        $sanitized_file_path = $conn->real_escape_string($file_path);
        $sql = "INSERT INTO posts (user_id, title, body, file_path) VALUES ($user_id, '$title', '$body', '$file_path')";
        $result = $conn->query($sql);
        return $result;
    }
}