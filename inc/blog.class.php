<?php
class blog
{
    private $id         = null;
    private $text       = null;
    private $title      = null;
    private $user_id    = null;
    private $created_at = null;

    public function __construct($text, $title)
    {
        $this->text  = $text;
        $this->title = $title;
    }

    public function validate()
    {
        if (strlen($this->text) < 1 or strlen($this->title) < 1) {
            return false;
        }
        return true;
    }

    public function createBlog($id)
    {
        $conn = db::connect() or die($conn->error);
        if ($conn->connect_errno) {
            return false;
        }
        $text = $conn->real_escape_string($this->text);
        $title = $conn->real_escape_string($this->title);
        $q = "INSERT INTO blogs 
                (title, text, user_id)
            VALUES
                ( '$title', '$text', '$id' );";
        $conn->query($q)
            or die("mysql error: createBlog(): " . $conn->error);
        // TODO: add created by
        $q =  "SELECT title, text FROM blogs WHERE id = $conn->insert_id";
        $result = $conn->query($q)
            or die("mysql error: createBlog(): " . $conn->error);
        $res = $result->fetch_assoc();
        return $res;
    }

    public static function get_blogs()
    {
        $conn = db::connect() or die($conn->error);
        if ($conn->connect_errno) {
            return false;
        }

        $q = "SELECT id, title, text, created_at, user_id FROM blogs ORDER BY created_at DESC";

        if (isset($_SESSION["logged_in"])) {
            $user_id = $conn->real_escape_string($_SESSION["user_id"]);
            $q = "SELECT id, title, text, created_at, user_id FROM blogs WHERE user_id='$user_id' ORDER BY created_at DESC";
        }

        $result = $conn->query($q);
        while ($row = $result->fetch_assoc())
            $rows[] = $row;
        $result->free();
        return $rows;
    }
}
