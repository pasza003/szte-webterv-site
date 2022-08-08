<?php

session_start();
require_once"connection.php";

if(!isset($_POST["delete_recipe"])){
    header("location: ../recipes.php");
}

$db = new Database();

$recipe_id = trim($_POST["recipe_id"]);

$sql_delete_recipe = "DELETE FROM recipes WHERE id = $recipe_id";
$db -> mysqli -> query($sql_delete_recipe);

header("location: ../recipes.php");
