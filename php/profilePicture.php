<?php

session_start();
require_once('connection.php');


$db = new Database();

$db -> delete_profile_pic_when_modified();

$error = [];

$id = $_SESSION["admin"] ?? $_SESSION["userID"];

$imgName = $_FILES['profile-picture']['name'];
$imgType = $_FILES['profile-picture']['type'];
$imgTmpName = $_FILES['profile-picture']['tmp_name'];
$imgSize = $_FILES['profile-picture']['size'];
$imgFormat = array("image/jpeg", "image/png", "image/jpg");



if (in_array($imgType, $imgFormat) && $imgSize < 16000000) {

        if (!file_exists("../profilePics\\" . $imgName)) {
            move_uploaded_file($imgTmpName, "../profilePics/" . $imgName);
            $resInsert = $db->profile_pics_update($id, $imgName);
            header("Location: ../profile.php?siker");


        }else{
            $error[] = "Valami hiba történt a profilkép feltöltésekor!";
            header("Location: ../profile.php");
        }

}else {
    $error[] = "Hiba! Nem megfelelő fájlformátum, vagy a fájl túl nagy!";
    header("Location: ../profile.php");
}



$_SESSION["profile_pic_error"] = $error;

?>
