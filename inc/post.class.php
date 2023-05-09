<?php 

class post
{
    private $post_id        = null;
    private $title          = null;
    private $body           = null;

    public function __construct($post_id)
    {
        if(!is_numeric($post_id))
            die('user constractor user_id is not numeric');
        $this->post_id  = $post_id;
    }

    /**
     * Requests posts from the DB. If user_id is provided - request his posts, else request all the posts
     *
     * @param user_id int
     * 
     * @return array(
                        "id"          => int,
                        "user_id"     => int,
                        "name"        => string,
                        "title"       => string,
                        "body"        => string,
                        "file_path"   => string
                    );  
     */ 
    public static function get_posts($user_id = null) 
    {
        // echo $user_id;
        $db = new db();
        
        $query = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id";

        if ($user_id) 
        {
            $query .= " WHERE user_id =  $user_id";
        }

        $query_res = $db->query($query);

        $rows = array();
        while($row = $query_res->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
        
    }


    /**
     * Upload a new file to the local folder
     *
     * @param user_id int
     * 
     * @return string
     */
    public static function upload_file($user_id)
    {
        //TODO: check if image is OK (correct size and type)
        $file_name = $_FILES["file"]["name"];
        $file_path = $_FILES["file"]["tmp_name"];

        post::validate_image($file_path);

        $new_file_folder = "../images/" . $user_id;

        if (!is_dir($new_file_folder)) 
        {
            mkdir($new_file_folder, 0777, true);
        }

        $new_filepath = $new_file_folder . "/" . $file_name;
        if(!move_uploaded_file($file_path, $new_filepath))
        {
            http_response_code(500);
            die(json_encode(['error'=>"Not uploaded because of error #".$_FILES["file"]["error"]])); 
        }

        return $new_filepath;
    }


    /**
     * Check if the file is of type image and that is in the correct size
     *
     * @param file_path string
     * 
     */
    public static function validate_image($file_path)
    {
        $file_size      = filesize($file_path);
        $file_info      = finfo_open(FILEINFO_MIME_TYPE);
        $file_type      = finfo_file($file_info, $file_path);

        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(500);
            die("Upload failed with error code " . $_FILES['file']['error']);
         }
         
         $info = getimagesize($file_path);
         if ($info === FALSE) {
            http_response_code(500);
            die("Unable to determine image type of uploaded file");
         }
         
         if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
            http_response_code(500);
            die("Not a gif/jpeg/png");
         }


         if ($file_size === 0 ) {
            http_response_code(500);
            die("file is empty");
         }

         if ($file_size > 5 * 1024 * 1024 ) {
            http_response_code(500);
            die("file is too big!");
         }

    
    }


    /**
     * Request DB to upload a new post
     *
     * @param title string
     * @param body string
     * @param user_id int
     * @param file_path string
     * 
     * @return mysqli_result
     */ 
    public static function upload_post($title, $body, $user_id, $file_path) 
    {
        $db             = new db();

        $title          = $db->real_escape_string($title);
        $body           = $db->real_escape_string($body);

        if ($file_path)
        {
            $file_path = $db->real_escape_string($file_path);
        }

        
        $query          = "INSERT INTO posts (title, body, user_id, file_path) VALUES ('$title', '$body', $user_id, '$file_path')";

        $query_res      = $db->query($query);

        return $query_res;
        
    }

    
    public function delete_post_by_user()
    {
        $this->delete_post($this->post_id);
    }


    /**
     * Request DB to delete a post
     *
     * @param user_id int
     * 
     * @return mysqli_result
     */ 
    private function delete_post($post_id) 
    {   

        // var_dump("delete " . $post_id);

        if (!is_numeric($post_id))
        {
            http_response_code(500);
            die('error in delete_post parameter');
        }
         
        $db             = new db();
        
        $query          = "DELETE FROM posts WHERE id = " . $post_id ;

        $query_res      = $db->query($query);

        return $query_res;
        
    }


    public function update_post_by_user($new_title) 
    {
        $this->update_post($this->post_id, $new_title);
    }


    /**
     * Request DB to update a post (edit the title of the post)
     *
     * @param user_id int
     * @param new_title string
     * 
     * @return mysqli_result
     */ 
    private function update_post($post_id, $new_title) 
    {
        if (!is_numeric($post_id))
        {
            http_response_code(500);
            die('error in update_post parameters');
        }

        $db             = new db();

        $new_title = $db->real_escape_string($new_title);
        
        $query          = "UPDATE posts SET title = '" . $new_title . "' WHERE id = " . $post_id ;

        $query_res      = $db->query($query);

        return $query_res;
        
    }

    
}