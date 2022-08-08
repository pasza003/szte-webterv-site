<?php
session_start();
require_once("connection.php");


$db = new Database();
$errors = [];



$id = $_SESSION["admin"] ?? $_SESSION["userID"];

if($id == null){
    header("location: ../login.php");
}

if(isset($_POST["private_update"])){
    $email_private = false;
    $birthdate_private = false;


    if(isset($_POST["private_email"]) && $_POST["private_email"] == "private_email"){
        $sql_private_email = "UPDATE users SET email_is_private = 1 WHERE id = $id";

    }else{
        $sql_private_email = "UPDATE users SET email_is_private = 0 WHERE id = $id";

    }
    $db -> mysqli -> query($sql_private_email);

    if(isset($_POST["private_birthdate"]) && $_POST["private_birthdate"] == "private_birthdate"){
        $sql_private_birthdate = "UPDATE users SET birthdate_is_private = 1 WHERE id = $id";

    }else{
        $sql_private_birthdate = "UPDATE users SET birthdate_is_private = 0 WHERE id = $id";

    }
    $db -> mysqli -> query($sql_private_birthdate);


    $sql_check_email_private = "SELECT email_is_private FROM users WHERE id = $id";
    $res_email_private = $db -> mysqli -> query($sql_check_email_private);
    $row_email_private = $res_email_private ->fetch_assoc();

    if($row_email_private["email_is_private"] == 1){
        $email_private = true;
    }

    $sql_check_birthdate_private = "SELECT birthdate_is_private FROM users WHERE id = $id";
    $res_birthdate_private = $db -> mysqli -> query($sql_check_birthdate_private);
    $row_birthdate_private = $res_birthdate_private -> fetch_assoc();

    if($row_birthdate_private["birthdate_is_private"] == 1){
        $birthdate_private = true;
    }

    header("location: ../profile.php?siker");


}else if(isset($_POST["update"])){


$username = trim($_POST["username"]);
$email = trim($_POST["email"]);
$pwd = trim($_POST["aPassword"]);
$newPwd = trim($_POST["newPassword"]);
$birthdate = trim($_POST["birthday"]);




if(($username == $newPwd)){
    $errors[] = "A felhasználónév és a jelszó nem lehet ugyanaz!";
}

if(strlen($username) < 6){
    $errors[] = "A felhasználónévnek legalább 6 karakternek kell lennie!";
}


if(empty($pwd)){
    $errors[] = "Kérem írja be az aktuális jelszavát!";
}

if (count($errors) === 0){
    $hash = password_hash($newPwd, PASSWORD_DEFAULT);

    $pwd = "SELECT password FROM users WHERE id = $id";
    $res = $db -> mysqli -> query($pwd);
    $row = $res -> fetch_assoc();

    if(password_verify($_POST['aPassword'],$row['password'])){


      if(!empty($newPwd) && !empty($birthdate)){
            $sql = " UPDATE users
               SET username= '$username', password='$hash', email = '$email',birthdate='$birthdate'
               WHERE id=$id ";

            $db -> mysqli -> query($sql);


        }else if(!empty($birthdate)){
            $sql = " UPDATE users
               SET username= '$username', birthdate='$birthdate', email = '$email'
               WHERE id=$id ";
            $db -> mysqli -> query($sql);

        }else{
            $sql = " UPDATE users
               SET username= '$username', email = '$email'
               WHERE id=$id ";
            $db -> mysqli -> query($sql);

        }

        if ($db -> mysqli -> connect_errno == 0){
            header("location: ../profile.php?siker_delete");
        }

    }
    if(isset($_POST["delete"])){
        $db -> delete_user($id);
        session_destroy();
        header("Location: ../index.php");
    }

}else{

    header("LOCATION: ../profile.php");
    $_SESSION["errors"] = $errors;
}
}


?>