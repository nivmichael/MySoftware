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

    public static function edit_blog($blog_id, $blog_title, $blog_text, $user_id)
    {
        $conn = db::connect() or die($conn->error);
        if ($conn->connect_errno) {
            return false;
        }
        // $user_id = $conn->real_escape_string($user_id);
        // $blog_id = $conn->real_escape_string($blog_id);
        $blog_title = $conn->real_escape_string($blog_title);
        $blog_text = $conn->real_escape_string($blog_text);

        // Check if this blog is connect to this user
        $q = "UPDATE blogs
        SET text = '$blog_text', title = '$blog_title'
        WHERE user_id = $user_id AND id = $blog_id;";
        return $conn->query($q) or die($conn->error);
    }

    public static function delete_blog($blog_id, $user_id)
    {
        $conn = db::connect() or die($conn->error);
        if ($conn->connect_errno) {
            return false;
        }
        $user_id = $conn->real_escape_string($user_id);
        $blog_id = $conn->real_escape_string($blog_id);
        // Check if this blog is connect to this user
        $q = "SELECT user_id FROM blogs WHERE id = '$blog_id' AND user_id = '$user_id'";
        $result =  $conn->query($q) or die($conn->error);
        if (!$result->num_rows) {
            return false;
        }
        $q        = "DELETE FROM blogs WHERE id = $blog_id";
        $conn->query($q)
            or die($conn->error);
        return true;
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
