<?php 

class post
{
    private $post_id        = null;
    private $title          = null;
    private $body           = null;

    public function __construct($post_id, $title, $body)
    {
        if(!is_numeric($post_id))
            die('user constractor user_id is not numeric');
        $this->post_id  = $post_id;
        $this->title    = $title;
        $this->body     = $body;
    }


    public static function get_posts($user_id = null) 
    {
        // echo $user_id;
        $db = new db();
        
        $query = "SELECT * FROM posts";

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


    public static function upload_file($user_id)
    {
        //TODO: check if image is OK (correct size and type)
        $file_name = $_FILES["file"]["name"];
        $file_path = $_FILES["file"]["tmp_name"];

        $new_file_folder = "../images/" . $user_id;

        if (!is_dir($new_file_folder)) 
        {
            mkdir($new_file_folder, 0777, true);
        }

        $new_filepath = $new_file_folder . "/" . $file_name;
        if(!move_uploaded_file($file_path, $new_filepath))
        {
            die(json_encode(['error'=>"Not uploaded because of error #".$_FILES["file"]["error"]])); 
        }

        return $new_filepath;
    }


    public static function upload_post($title, $body, $user_id, $file_path) 
    {
        $db             = new db();
        
        $query          = "INSERT INTO posts (title, body, user_id, file_path) VALUES ('$title', '$body', $user_id, '$file_path')";

        $query_res      = $db->query($query);

        return $query_res;
        
    }


    public static function delete_post($post_id) 
    {
        $db             = new db();
        
        $query          = "DELETE FROM posts WHERE id = " . $post_id ;

        $query_res      = $db->query($query);

        return $query_res;
        
    }

    
}