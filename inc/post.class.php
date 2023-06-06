<?php
class post
{
    private $mysqli  = null;
    private $user_id = null;
    private $title   = null;
    private $body    = null;

    public function __construct($user_id = null, $title = null, $body = null)
    {
        if (!$this->user_id) {
            $this->user_id = $user_id;
            $this->title   = $title;
            $this->body    = $body;
        }
    }
    
    public function save_post()
    {
        $data = [];
        $response = null;

        // Connect to DB          
        $this->mysqli     = db::connect();
        $title            = $this->mysqli ->real_escape_string(trim(strip_tags($this->title)));
        $body             = $this->mysqli ->real_escape_string(trim(strip_tags($this->body)));

        // Insert post data to posts table
        $sql = "INSERT INTO posts (user_id, title, body)
         VALUES ($this->user_id,
                 '$title',
                 '$body')";

        $res = $this->mysqli ->query($sql) 
            or die("Mysql error: save_post()" . $this->mysqli->error);

        // Gets the Sql row from res
        $data = $res->fetch_row();

        // checks if $data[0] is not null => sets response with id
        if(isset($data[0])) 
        {
            $response = $data;    
        }

        return $response;
    }

    public function get_all_posts() 
    {
        $data = [];
        $response = null;

         // Executes sql statement to get id from posts table by username and password     
        $sql = "SELECT *
        FROM posts 
        WHERE user_id = $this->user_id";

        $res = $this->mysqli ->query($sql) 
            or die("Mysql error: get_all_posts()" . $this->mysqli ->error);
        
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
