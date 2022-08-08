<?php
session_start();
require_once("connection.php");

if(!isset($_POST["create-recipe"])){
    header("location: ../recipes.php");
}

$db = new Database();
$error = [];

$id = $_SESSION["admin"] ?? $_SESSION["userID"];
$recipe_name = trim($_POST["recipe-name"]);
$portion = trim($_POST["portion"]);
$time = trim($_POST["time"]);
$url = trim($_POST["recipe-video-link"]);

$ingredients = trim($_POST["recipe-ingredients"]);
$ingredients_with_enters = nl2br($ingredients);


$ingredients_final = str_replace(PHP_EOL, ";",$ingredients);


$instructions = trim($_POST["recipe-instructions"]);
$instructions_with_enters = nl2br($instructions);
$instructions_final = str_replace(PHP_EOL,";",$instructions);

$date = date("Y-m-d");
$slug = str_replace(" ", "-",$recipe_name);



$imgName = $_FILES['recipe-picture']['name'];
$imgType = $_FILES['recipe-picture']['type'];
$imgTmpName = $_FILES['recipe-picture']['tmp_name'];
$imgSize = $_FILES['recipe-picture']['size'];
$imgFormat = array("image/jpeg", "image/png", "image/jpg");

if(empty($recipe_name) || empty($portion) || empty($time) || empty($ingredients) || empty($instructions) || empty($imgName)){
    $error[] = "Tölts ki minden mezőt! Ne felejts el képet is felrakni.";
}

if (in_array($imgType, $imgFormat) && $imgSize < 16000000 && count($error) == 0) {

    if (!file_exists("../img\\" . $imgName)) {
        move_uploaded_file($imgTmpName, "../img/" . $imgName);
        $resInsert = $db-> insert_recipe_db($id,$recipe_name,$imgName,$url,$portion,$time,$ingredients_final,$instructions_final,$date,$slug);
    } else{
        $error[] = "Valami hiba történt a kép feltöltésekor!";
    }

}else {
    $error[] = "Hiba! Nem megfelelő fájlformátum, vagy a fájl túl nagy!";
}
header("location: ../recipes.php");

if(count($error) > 0){
    $_SESSION["create_recipe_errors"] = $error;
    header("location: ../create-recipe.php");
}



