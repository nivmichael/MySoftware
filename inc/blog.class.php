<?php
class blog
{
    private $id         = null;
    private $text       = null;
    private $title      = null;
    private $user_id    = null;
    private $created_at = null;
    private $file_ext = null;

    public function __construct($title = null, $text = null, $id = null, $user_id = null, $created_at = null, $file_ext = null)
    {
        $this->text  = $text;
        $this->title = $title;
        $this->user_id = $user_id;
        $this->created_at = $created_at;
        $this->id = $id;
        $this->file_ext = $file_ext;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function validate()
    {
        if (strlen($this->text) < 1 or strlen($this->title) < 1) {
            return false;
        }
        return true;
    }

    public function update_file_ext($file_ext)
    {
        $conn = db::connect() or die($conn->error);
        $file_ext = $conn->real_escape_string($file_ext);

        $q = "UPDATE blogs
        SET file_ext = '$file_ext'
        WHERE id = $this->id;";

        // Check this blog connect to this user that try to perform this action
        // $q = "UPDATE blogs
        // SET text = '$blog_text', title = '$blog_title'
        // WHERE user_id = $user_id AND id = $this->id;";
        return $conn->query($q) or die($conn->error);
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
        $q  = "SELECT b.id, b.title, b.text, b.created_at, b.user_id, u.username 
            FROM blogs AS b JOIN users AS u ON (b.user_id = u.id)
            WHERE b.id = $conn->insert_id ORDER BY b.created_at DESC;";        
        $result = $conn->query($q)
            or die("mysql error: createBlog(): " . $conn->error);
        return $result->fetch_assoc();
    }

    public function upload_file($blog_id)
    {

        $target_dir = "../images/";

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $tar_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($tar_file, PATHINFO_EXTENSION));
        $target_file = $target_dir . $blog_id . "." . $imageFileType;
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        $msg = "";
        if ($check !== false) {
            $msg = $msg . "File is an image - " . $check["mime"] . ".\n";
            $uploadOk = 1;
        } else {
            $msg = $msg . "File is not an image.";
            $uploadOk = 0;
        }
        
        // Check if file already exists
        if (file_exists($target_file)) {
            $msg = $msg . "Sorry, file already exists.";
            $uploadOk = 0;
        }
        
        // Check file size
        if ($_FILES["file"]["size"] > 500000) {
            $msg = $msg . "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $msg = $msg . "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $msg = $msg . "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $msg = $msg . "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
            } else {
                $msg = $msg . "Sorry, there was an error uploading your file.";
            }
        }
        $res = [
            "file_ext" => $imageFileType,
            "messege"  =>  $msg
        ];
        return $res;
    }

    public function edit_blog($user_id)
    {
        $conn = db::connect() or die($conn->error);
        if ($conn->connect_errno) {
            return false;
        }
        if (!isset($user_id) || !is_numeric($user_id)) {
            return false;
        }
        if (!isset($this->id) || !is_numeric($this->id)) {
            return false;
        }
        $blog_title = $conn->real_escape_string($this->title);
        $blog_text = $conn->real_escape_string($this->text);

        // Check this blog connect to this user that try to perform this action
        $q = "UPDATE blogs
        SET text = '$blog_text', title = '$blog_title'
        WHERE user_id = $user_id AND id = $this->id;";
        return $conn->query($q) or die($conn->error);
    }

    public function delete_blog($user_id)
    {
        if (!isset($this->id) || !is_numeric($this->id)) {
            return "no id";
        }
        if (!isset($user_id) || !is_numeric($user_id)) {
            return "no user id";
        }
        $conn = db::connect() or die($conn->error);
        if ($conn->connect_errno) {
            return "connect_errno";
        }
        // Check if this blog is connect to this user
        $q = "SELECT user_id FROM blogs WHERE id = $this->id AND user_id = $user_id";
        $result =  $conn->query($q) or die($conn->error);
        if (!$result->num_rows) {
            return false;
        }
        $q = "DELETE FROM blogs WHERE id = $this->id";
        $conn->query($q)
            or die($conn->error);
        return true;
    }

    public function get_blogs()
    {
        $conn = db::connect() or die($conn->error);
        if ($conn->connect_errno) {
            return false;
        }

        $q = "SELECT b.id, b.title, b.text, b.created_at, b.user_id, u.username, b.file_ext FROM blogs AS b JOIN users AS u ON (b.user_id = u.id) ORDER BY b.created_at DESC;";

        if (isset($_SESSION["logged_in"])) {
            $user_id = $conn->real_escape_string($_SESSION["user_id"]);
            $q = "SELECT b.id, b.title, b.text, b.created_at, b.user_id, u.username, b.file_ext FROM blogs AS b JOIN users AS u ON (b.user_id = u.id) WHERE user_id='$user_id' ORDER BY b.created_at DESC;";
        }

        $result = $conn->query($q);
        while ($row = $result->fetch_assoc())
            $rows[] = $row;
        $result->free();
        return $rows;
    }
}
