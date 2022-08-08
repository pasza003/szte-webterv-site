<?php

require_once("comment.php");

class Database{
    private $host;
    private $user;
    private $pwd;
    private $db;
    private $port;

    public $mysqli;


    public function __construct(){

        $this->host = "localhost";
        $this->user = "root";
        $this->pwd = "";
        $this->db = "szte-webterv";
        $this->port = "3306";

        $this->mysqli = new mysqli($this->host,$this->user,$this->pwd,$this->db,$this->port);

    }


    public function insert_users_to_db($username, $email, $password, $birthdate){
        $db = new Database();

        $sql = "INSERT INTO users (username,email,password,birthdate,picture) VALUES ('$username','$email','$password','$birthdate','default.jpg')";

        $db -> mysqli -> query($sql);
    }
    

    public function login($username){
        $db = new Database();

        $sql = "SELECT * FROM users WHERE username = '$username' ";
        return $db -> mysqli -> query($sql);
    }


    public function profile_pics_update($userID, $imgname){
        $db = new Database();

        $sql_update = "UPDATE users SET picture = '$imgname' WHERE id = $userID";

        return $db -> mysqli -> query($sql_update);

    }

    public function delete_profile_pic_when_modified(){
        $db = new Database();

        $id = $_SESSION["admin"] ?? $_SESSION["userID"];


        $sqlselect = "SELECT * FROM users WHERE id = $id";
        $resSelect = $db -> mysqli -> query($sqlselect);

        $row = $resSelect -> fetch_assoc();

        $currentProfilePicture = $row["picture"];

        $fileName = "../profilePics/$currentProfilePicture";

        if($currentProfilePicture != "default.jpg" && file_exists($fileName)){
            unlink($fileName);
        }
    }

    public function get_user_id(string $username): int
    {

        $sql_get_addressee_id = "SELECT id FROM users where username = '$username'";

        $res = $this->mysqli ->query($sql_get_addressee_id);
        $row = $res -> fetch_assoc();

        if(!is_null($row)){
            return (int)$row["id"];
        }

        return 0;

    }


    public function insertMessageToDB(int $userID, int $addressee_ID, string $content)
    {
        $sql_add = "INSERT INTO inbox (sender_id,receiver_id,message) values ($userID,$addressee_ID,'$content')";
        $this->mysqli -> query($sql_add);
    }

    function get_comments($recipe_id): array
    {
        $db = new Database();

        $comment_array = [];


        $sql_select_comments = "SELECT users.username,comment,comments.id,comments.user_id FROM comments INNER JOIN users ON users.id = comments.user_id where recipe_id = $recipe_id ORDER BY comments.id";
        $result_comment = $db -> mysqli -> query($sql_select_comments);
        $row_comment = $result_comment -> fetch_all();

        foreach ($row_comment as $comment){
            $comment_array[] = new comment($comment[0],$comment[1],$comment[2],$comment[3]);
        }


        return $comment_array;

    }

    public function insert_recipe_db($userid,$name,$pic,$url,$portion,$time,$ingredients,$instructions,$date,$slug){
        $sql_insert_recipe = "INSERT INTO `recipes` (`user_id`, `name`, `image_name`, `video_url`, `portion`, `time`, `ingredients`, `instructions`, `upload_date`, `slug`) VALUES ('$userid','$name','$pic','$url','$portion','$time','$ingredients','$instructions','$date','$slug')";
        $this->mysqli -> query($sql_insert_recipe);
    }

    public function delete_user($id){
        $sql_delete_user_comments = "DELETE FROM comments WHERE user_id = $id";
        $sql_delete_user = "DELETE FROM users where id=$id";
        $sql_delete_recipes = "DELETE FROM recipes where user_id = $id";
        $sql_delete_messages = "DELETE FROM inbox where sender_id = $id OR receiver_id = $id";



        $this ->mysqli -> query($sql_delete_user_comments);
        $this -> mysqli -> query($sql_delete_recipes);
        $this -> mysqli -> query($sql_delete_messages);
        $this -> mysqli -> query($sql_delete_user);
    }


}