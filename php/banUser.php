<?php

session_start();

require_once("connection.php");

if(!isset($_POST["delete_user_by_admin"])){
    header("location: ../profile.php");
}

$db = new Database();


$username = trim($_POST["username"]);
$errors = [];


if(empty($username)){
    $errors[] = "Üres értéket adsz át!";
}

if(count($errors) == 0){
    $username_id = $db -> get_user_id($username);
    if(empty($username_id)){
        $errors[] = "Nincs meg a felhasználó!";
    }
}

if(count($errors) == 0){

    $db -> delete_user($username_id);

    header("location: ../profile.php?siker_delete");
}else{
    header("location: ../profile.php");
}

$_SESSION["ban_error"] = $errors;



