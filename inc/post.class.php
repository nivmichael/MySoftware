<?php 
include '../autoloader.php';

class post
{
    private $post_id  = null;
    private $title = null;
    private $body     = null;

    public function __construct($post_id, $title, $body)
    {
        if(!is_numeric($post_id))
            die('user constractor user_id is not numeric');
        $this->post_id  = $post_id;
        $this->title = $title;
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


    public static function upload_post($title, $body, $user_id, $file_path) 
    {

        $db = new db();
        
        $query = "INSERT INTO posts (title, body, user_id, file_path) VALUES ('$title', '$body', $user_id, '$file_path')";

        $query_res = $db->query($query);

        return $query_res;
        
    }

    
}