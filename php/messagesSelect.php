<?php
require_once('connection.php');
session_start();

if(!isset($_SESSION["admin"])) {
    if (!isset($_SESSION["userID"])) {
        header("location: login.php");
    }
}

class messagesSelect{




    public function messageArray($user): array
    {

        $db = new Database();
        $id = $_SESSION["admin"] ?? $_SESSION["userID"];

        $messageArray = [];

        $sql_select_messages = "SELECT users.username,inbox.message FROM users INNER JOIN inbox ON users.id = inbox.sender_id WHERE (receiver_id = $id AND sender_id = $user) OR (receiver_id = $user AND sender_id = $id)";
        $res = $db -> mysqli -> query($sql_select_messages);
        $row = $res -> fetch_all();


        foreach ($row as $message){
            $messageArray[] = new message($message[0],$message[1]);
        }

        return $messageArray;

    }

    public function friends(): array{

        $db = new Database();
        $id = $_SESSION["admin"] ?? $_SESSION["userID"];
        $friend_users_array = [];

        $sql_friends = "SELECT DISTINCT users.username FROM users INNER JOIN inbox ON users.id = inbox.sender_id WHERE receiver_id = $id";
        $res = $db -> mysqli -> query($sql_friends);
        $row = $res -> fetch_all();

        foreach ($row as $friends){
            $friend_users_array[] = $friends;
        }


        return $friend_users_array;


    }



}





