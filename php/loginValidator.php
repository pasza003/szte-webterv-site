<?php
session_start();
require_once('connection.php');

$db = new Database();
$error = [];

if (isset($_POST['login'])){
    $userName = $_POST['username'];
    $pwd = $_POST['password'];
    $res = $db -> login($userName);



    if($userName === "" || $pwd === ""){
        $error[] = "Minden mezőt tölts ki!";
        header("Location: ../login.php");
    }else if ($res) {

        if($res -> num_rows == 1){
            //belépett
            $row = $res -> fetch_row();

            if (password_verify($pwd, $row[3]))
            {
                $sql_admin = "select admin from users where id = $row[0]";
                $res_admin = $db -> mysqli ->query($sql_admin);
                $row_admin = $res_admin -> fetch_assoc();

                $admine = $row_admin["admin"];

                if($admine == 1){
                    $_SESSION["admin"] = $row[0];
                }else{
                    $_SESSION['userID'] = $row[0];
                }

                header("location: ../profile.php");

            }else {
                $error[] = "Helytelen jelszó!";
                header("Location: ../login.php");
            }
        }else{
            $error[] = "Helytelen felhasználónév!";
            header("Location: ../login.php");
        }
    }
    $_SESSION["errors"] = $error;

} else {
    if(!isset($_SESSION["userID"])){
        header("location: ../login.php");
    }
}
?>