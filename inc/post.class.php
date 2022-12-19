<?php 
class post
{
    // DB connect to get all posts. Returns all posts
    public static function get_posts($user_id = null) 
    {
        $conn = new db();
        $where = ($user_id)? "WHERE posts.user_id = $user_id":null;
        $sql = "SELECT posts.*,users.name FROM posts JOIN users ON posts.user_id = users.id $where ORDER BY id DESC";
        $queryresult = $conn->query($sql)
                    or die("Error in post::get_all_posts $conn->error");
        $result = [];
        while($row = $queryresult->fetch_array())
        {
            $result[] = array(
                            "id"          => $row["id"],
                            "user_id"     => $row["user_id"],
                            "name"        => $row["name"],
                            "title"       => $row["title"],
                            "body"        => $row["body"],
                            "file_path"   => $row["file_path"],
                            "uploaded_on" => $row["uploaded_on"]
                            );
        }
        return $result;
    }

    // DB connect and query post upload, returns true or false
    public static function upload_post($user_id, $title, $body, $file_path = null) 
    {
        $conn = new db();
        $sanitized_title = $conn->real_escape_string($title);
        $sanitized_body = $conn->real_escape_string($body);
        $sanitized_file_path = $conn->real_escape_string($file_path);
        $sql = "INSERT INTO posts (user_id, title, body, file_path) VALUES ($user_id, '$sanitized_title', '$sanitized_body', '$sanitized_file_path')";
        $result = $conn->query($sql)
                    or die("Error in post::get_all_posts $conn->error");
        return $result;
    }
}