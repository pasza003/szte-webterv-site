<?php
session_start();
require_once('connection.php');


if(isset($_SESSION["recipe_name"])){
    $recipe_name = $_SESSION["recipe_name"];
}else{
    header("location: ../recipe.php");
}

$error = [];

if(!isset($_POST["comment"])){
    header("location: ../recipe.php");
}

if(!isset($_SESSION["userID"])){
    $error[] = "Csak úgy tudsz hozzászólni ha belépsz!";
    header("location: ../recipe.php?name=$recipe_name");
}

if(isset($_SESSION["recipe_name"])){
    $recipe_name = $_SESSION["recipe_name"];
}else{
    header("location: ../recipe.php");
}

$db = new Database();


$comment = trim($_POST["recipe-comment"]);


$id = $_SESSION["admin"] ?? $_SESSION['userID'];


if(isset($_SESSION["recipe_id"])){
    $recipe_id = $_SESSION["recipe_id"];
}else{
    header("location: ../recipe.php");
}

if(empty($comment)){
    $error[] = "Ne hagyd üresen a mezőt!";
}

if(count($error) == 0){
    $sql_insert_comment = "insert into comments (user_id,recipe_id,comment) values ($id,$recipe_id,'$comment')";
    $db -> mysqli -> query($sql_insert_comment);
}



$_SESSION["comment_error"] = $error;
header("location: ../recipe.php?name=$recipe_name");

