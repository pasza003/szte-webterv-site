<?php
session_start();
require_once("connection.php");

if(!isset($_SESSION["userID"])){
    header("location: ../login.php");
}


$db = new Database();
$userID = $_SESSION["userID"];

$content = trim($_POST["content"]);
$errors = [];

if(isset($_SESSION["chat_username_id"]) && $_SESSION["chat_username"]){
    $chat_username_id = $_SESSION["chat_username_id"];
    $chat_username = $_SESSION["chat_username"];
}



if(isset($_POST["send_message"])){

    if(empty($content)){
        $errors[] = "Ne hagyd üresen az üzenetet!";
        header("LOCATION: ../chat.php");
    }else{
        $db ->insertMessageToDB($userID,$chat_username_id,$content);
        header("Location: ../chat.php?user=$chat_username");
    }


}

if(isset($_POST["user_check"])){
    $addressee = trim($_POST["cimzett"]);
    $addressee_ID = $db->get_user_id($addressee);

    $sql_check_user = "SELECT id FROM users WHERE id = $addressee_ID";

    $res = $db -> mysqli ->query($sql_check_user);
    $row = $res -> fetch_assoc();

    if(is_null($row)){
        $errors[] = "Nincs ilyen felhasználó!";
        header("LOCATION: ../new-message.php");
    }else{
        header("LOCATION: ../new-message.php?siker");
    }

    $_SESSION["cimzett"] = $addressee;

}

if(isset($_POST["send_new_message"])){
    $addressee = trim($_POST["cimzett"]);
    $addressee_ID = $db->get_user_id($addressee);
    $id = $_SESSION["admin"] ?? $_SESSION["userID"];

    $db -> insertMessageToDB($id,$addressee_ID,$content);

    header("LOCATION: ../inbox.php");
}

$_SESSION["error"] = $errors;
$_SESSION["content"] = $content;















