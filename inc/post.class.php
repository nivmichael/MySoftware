<?php
class post
{
    private $post_id = null;
    private $user_id = null;
    private $title   = null;
    private $body    = null;

    public function __construct($post_id = null, $user_id = null, $title = null, $body = null)
    {
        if (!$this->post_id) {
            $this->post_id = $post_id;
            $this->user_id = $user_id;
            $this->title   = $title;
            $this->body    = $body;
        }
    }

    public function set_post_id($post_id)
    {
        if (is_numeric($post_id)) {
            $this->post_id = $post_id;
        }
        return $this->post_id;
    }

    public function set_user_id($user_id)
    {
        if (is_numeric($user_id)) {
            $this->user_id = $user_id;
        }
        return $this->user_id;
    }

    public function set_body($body)
    {
        $this->body = $body;
    }

    public function set_title($title)
    {
        $this->title = $title;
    }
    
    public function save_post()
    {
        $data = [];
        $response = null;

        // Connect to DB          
        $mysqli     = db::connect();
        $title = $mysqli->real_escape_string(trim(strip_tags($this->title)));
        $body = $mysqli->real_escape_string(trim(strip_tags($this->body)));

        // Insert post data to posts table
        $sql = "INSERT INTO posts (user_id, title, body)
         VALUES ($this->user_id,
                 '$title',
                 '$body')";

        $res = $mysqli->query($sql) 
            or die("Mysql error: save_post()" . $mysqli->error);

        $last_id = $mysqli->insert_id;

        // Executes sql statement to get id from posts table by username and password     
        $sql = "SELECT *
        FROM posts 
        WHERE user_id = $this->user_id
        AND post_id = $last_id";

        $res = $mysqli->query($sql) 
            or die("Mysql error: save_post()" . $mysqli->error);

        // Gets the Sql row from res
        $data = $res->fetch_row();

        // checks if $data[0] is not null => sets response with id
        if(isset($data[0])) 
        {
            $response = $data;    
        }

        return $response;
    }
}
