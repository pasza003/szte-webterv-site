<?php
session_start();
require_once("connection.php");

if (!isset($_POST["register"])){
    header("Location: ../login.php");
}

$db = new Database();

$errors = [];
$username = trim($_POST["username"]);
$email = trim($_POST["email"]);
$password = trim($_POST["password"]);
$passwordConfirm = trim($_POST["password-check"]);
$bdate = trim($_POST["birthdate"]);

    if ($username === "" || $email === "" || $password === "" ||
        $passwordConfirm === "" || $bdate === "") {
        $errors[] = "Minden kötelezően kitöltendő mezőt ki kell tölteni!";
    }


    $sqlselect = "SELECT * FROM users WHERE username = '$username'";
    $resSelect = $db->mysqli->query($sqlselect);
    $row = $resSelect->fetch_all();

    if(!empty($row)) {
        $errors[] = "A felhasználónév már foglalt!";
    }

    if(($username == $password)){
        $errors[] = "A felhasználónév és a jelszó nem lehet ugyanaz!";
    }

    if(strlen($username) < 6){
        $errors[] = "A felhasználónévnek legalább 6 karakternek kell lennie!";
    }

    if(strlen($password) < 6){
        $errors[] = "A jelszónak legalább 6 karakternek kell lennie!";
    }

    if (!preg_match("/[A-Za-z]/", $password) || !preg_match("/[0-9]/", $password)) {
        $errors[] = "A jelszónak tartalmaznia kell betűt és számjegyet is!";
    }

    if (!preg_match("/[0-9a-z.-]+@([0-9a-z-]+\.)+[a-z]{2,4}/", $email)) {
        $errors[] = "A megadott e-mail cím formátuma nem megfelelő!";
    }

    if ($password !== $passwordConfirm) {
        $errors[] = "A két jelszó nem egyezik!";
    }

    $sqlselect = "SELECT * FROM users WHERE email = '$email'";
    $resSelect = $db->mysqli->query($sqlselect);
    $row = $resSelect->fetch_all();
    if(!empty($row)) {
        $errors[] = "Az email cím már foglalt!";
    }

    if (count($errors) === 0) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $db->insert_users_to_db($username,$email,$hash,$bdate);
        header("Location: ../login.php");
    }else{
        header("Location: ../register.php");
    }



$_SESSION["reg_username"] = $username;
$_SESSION["reg_email"] = $email;
$_SESSION["reg_bdate"] = $bdate;

$_SESSION["reg_errors"] = $errors;


