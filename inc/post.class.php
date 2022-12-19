<?php 
class post
{
    /**
     * DB connect to get posts. If gets user_id returns user's posts, otherwise returns all posts
     *
     * @param user_id int
     * 
     * @return array(
                        "id"          => int,
                        "user_id"     => int,
                        "name"        => string,
                        "title"       => string,
                        "body"        => string,
                        "file_path"   => string,
                        "uploaded_on" => timestamp,
                    );
     */ 
    public static function get_posts($user_id = null) 
    {
        if($user_id && !is_numeric($user_id))
            die("user constractor user_id is not numeric");

        $conn        = new db();
        $where       = ($user_id)? "WHERE posts.user_id = $user_id":null;
        $sql         = "SELECT posts.*,
                               users.name 
                        FROM posts 
                        JOIN users ON posts.user_id = users.id 
                        $where 
                        ORDER BY id DESC";
        $queryresult = $conn->query($sql)
                        or die("Error in post::get_posts $conn->error");
        $result      = [];
        
        while($row = $queryresult->fetch_array())
        {
            $result[] = array(
                                "id"          => $row["id"],
                                "user_id"     => $row["user_id"],
                                "name"        => $row["name"],
                                "title"       => $row["title"],
                                "body"        => $row["body"],
                                "file_path"   => $row["file_path"],
                                "uploaded_on" => $row["uploaded_on"],
                            );
        }
        return $result;
    }

    /**
     * DB connect and query post upload, returns true or false
     *
     * @param user_id int
     * @param title string
     * @param body string
     * @param file_path string
     * 
     * @return boolean true/false if upload success/fail
     */ 
    public static function upload_post($user_id, $title, $body, $file_path = null) 
    {
        if(!is_numeric($user_id))
            die("user constractor user_id is not numeric");

        $conn                = new db();
        $sanitized_title     = $conn->real_escape_string($title);
        $sanitized_body      = $conn->real_escape_string($body);
        $sanitized_file_path = $conn->real_escape_string($file_path);
        $sql                 = "INSERT INTO posts (user_id, title, body, file_path) 
                                VALUES ($user_id, '$sanitized_title', '$sanitized_body', '$sanitized_file_path')";
        $result              = $conn->query($sql)
                                or die("Error in post::get_all_posts $conn->error");
        return $result;
    }

    /**
     * Validates that title,body exist
     *
     * @param title string
     * @param body string
     * 
     * @return array("status"=>boolean, "data"=>string)
     */ 
    public static function validate_upload_post_text_data($title, $body) 
    {
        $result = [
            "status" => true,
            "data"   => "",
        ];
        // Validator that title exist
        if (!$title) 
        {
            $result["status"] = false;
            $result["data"]  .= "Title is required"."</br>";
        }
        // Validator that body exist
        if (!$body) 
        {
            $result["status"] = false;
            $result["data"]  .= "Body is required"."</br>";
        }
        return $result;
    }

    /**
     * Validates that title,body exist
     *
     * @param 
     * 
     * @return array("status"=>boolean, "data"=>string)
     */ 
    public static function validate_and_upload_img($file_path)
    {
        $result         = [
                            "status" => true,
                            "data"   => "",
                        ];

        $file_size      = filesize($file_path);
        $file_info      = finfo_open(FILEINFO_MIME_TYPE);
        $file_type      = finfo_file($file_info, $file_path);
        $allowed_types  = [
                            "image/png" => "png",
                            "image/jpeg" => "jpg",
                            "image/gif" => "gif",
                          ];

        if ($file_size === 0) 
        {
            $result["status"] = false;
            $result["data"]  .= "The file is empty"."</br>";
        }
        else if ($file_size > 3145728) // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))
        { 
            $result["status"] = false;
            $result["data"]  .= "The file is too big"."</br>";
        }
        else if (!in_array($file_type, array_keys($allowed_types))) 
        {
            $result["status"] = false;
            $result["data"]  .= "File type not allowed"."</br>";
        }
        else 
        {
            // Create root with user"s folder if doesn"t exist
            $target_dir = "../uploads/" . $_SESSION["user_id"] . "/";
            if (!is_dir($target_dir)) 
            {
                mkdir($target_dir, 0777, true);
            }
        }
        return $result;
    }
}