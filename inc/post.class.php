<?php
class post
{
    private $user_id = null;
    private $title   = null;
    private $body    = null;

    public function __construct($title = null, $body = null)
    {
        if (!$this->title) {
            $this->title   = $title;
            $this->body    = $body;
        }
    }

    public function set_user_id($user_id)
    {
        $this->user_id = $user_id;
    }

    public function set_title($title)
    {
        $this->title = $title;
    }

    public function set_body($body)
    {
        $this->body = $body;
    }

    // Return last inserted id if save post was successful, if not it will be return null
    public function save_post()
    {
        // Connect to DB          
        $mysqli           = db::connect();
        $title            = $mysqli->real_escape_string(trim(strip_tags($this->title)));
        $body             = $mysqli->real_escape_string(trim(strip_tags($this->body)));

        // Insert post data to posts table
        $q = "INSERT INTO posts (user_id, title, body)
         VALUES ($this->user_id,
                 '$title',
                 '$body')";

        $mysqli->query($q)
            or die("Mysql error: save_post()" . $mysqli->error);

        return $mysqli->insert_id;
    }

    public function get_posts()
    {
        $data   = [];
        $mysqli = db::connect();

        $where = $this->user_id ? " WHERE user_id = $this->user_id" : "";

        $q = "SELECT user_id, post_id, title, body, file_name
              FROM posts $where ;";

        $res = $mysqli->query($q)
            or die("Mysql error: get_all_posts()" . $mysqli->error);

        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function update_post($id)
    {
        $mysqli = db::connect();

        $title            = $mysqli->real_escape_string(trim(strip_tags($this->title)));
        $body             = $mysqli->real_escape_string(trim(strip_tags($this->body)));

        $q = "UPDATE posts
                SET title = '$title', body= '$body'
                WHERE user_id = $this->user_id AND post_id = $id";

        $response = $mysqli->query($q)
            or die("Mysql error: update_post()" . $mysqli->error);
      
        return $response;
    }

    public function delete_post($id)
    {
        $mysqli = db::connect();

        $q = "DELETE FROM posts WHERE post_id = $id";

        $response = $mysqli->query($q)
            or die("Mysql error: delete_post()" . $mysqli->error);
        
        return $response;
    }

    public function upload_picture_post($id, $current_name)
    {
        $mysqli = db::connect();

        $id_str = strval($id);
    
        $q = "UPDATE posts
        SET file_name =  CONCAT(NOW(), '_','$id_str', '_', '$current_name')
        WHERE post_id = $id";

        $response = $mysqli->query($q)
            or die("Mysql error: upload_picture_post()" . $mysqli->error);
        
        return $response;
    }
}
