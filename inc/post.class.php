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


    public function save_post()
    {
        $response = null;

        // Connect to DB          
        $mysqli           = db::connect();
        $title            = $mysqli->real_escape_string(trim(strip_tags($this->title)));
        $body             = $mysqli->real_escape_string(trim(strip_tags($this->body)));

        // Insert post data to posts table
        $q = "INSERT INTO posts (user_id, title, body)
         VALUES ($this->user_id,
                 '$title',
                 '$body')";



        $response = $mysqli->query($q)
            or die("Mysql error: save_post()" . $mysqli->error);

        return $response;
    }

    public function get_posts()
    {
        $mysqli = db::connect();

        $q = "SELECT * FROM posts";
        if ($this->user_id) {
            $user_id = $this->user_id;
            $q = $q . " WHERE user_id = $user_id";
        }
        $q = $q . ";";

        $res = $mysqli->query($q)
            or die("Mysql error: get_all_posts()" . $mysqli->error);

        return $res->fetch_all();
    }
}
