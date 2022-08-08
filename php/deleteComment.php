<?php

session_start();
require_once("connection.php");

if(isset($_SESSION["recipe_name"])){
    $recipe_name = $_SESSION["recipe_name"];
}else{
    header("location: ../recipe.php");
}

$db = new Database();

if(isset($_POST["delete_comment"])){
    $comment_id = trim($_POST["comment_id"]);

    $sql_delete_comment = "DELETE FROM comments WHERE id = $comment_id";

    $db -> mysqli -> query($sql_delete_comment);
}


header("location: ../recipe.php?name=$recipe_name");
