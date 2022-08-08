<?php
    include "php/includes.php";
    require_once("php/profileSelect.php");

    $dataBase = new Database();

    if(isset($_SESSION["errors"])){
        $error = $_SESSION["errors"];
    }else{
        $error[] = null;
    }

    if(isset($_SESSION["profile_pic_error"])){
        $pic_error = $_SESSION["profile_pic_error"];
    }else{
        $pic_error[] = null;
    }

    $ownProfile = false;

    $db = new Database();

    if(!isset($_SESSION["admin"])){
        if (!isset($_SESSION["userID"]) && !isset($_GET["name"])) {
            header("Location: ./login.php");
        }
    }

    if(isset($_GET["name"])){
        $username = $_GET["name"];
    }


    if (isset($_SESSION["userID"]) || isset($_SESSION["admin"])) {

        $id = $_SESSION["userID"] ?? $_SESSION["admin"];
        if (!isset($_GET['name'])) {
            $sqlselect = "SELECT * FROM users WHERE id = '$id'";
            $resSelect = $db->mysqli->query($sqlselect);
            $userSelect = $resSelect->fetch_row();
            $user = new User($userSelect[0],$userSelect[1],$userSelect[2],$userSelect[3],$userSelect[4],$userSelect[5], $userSelect[6],$userSelect[7],$userSelect[8]);
            $ownProfile = true;
        } else {
            if ($username == null) {
                header("Location: ./index.php");
            }
            $username = $_GET['name'];
            $sqlselect = "SELECT * FROM users WHERE username = '$username'";
            $resSelect = $db->mysqli->query($sqlselect);
            $userSelect = $resSelect->fetch_row();

            if(!empty($userSelect)){
                $user = new User($userSelect[0],$userSelect[1],$userSelect[2],$userSelect[3],$userSelect[4],$userSelect[5], $userSelect[6],$userSelect[7],$userSelect[8]);
            }else{
                header("Location: ./index.php");
            }

            if ($user->getID() == $id) {
                $ownProfile = true;
            }
        }
    } else {
        $username = $_GET['name'];
        if ($username == null) {
            header("Location: ./login.php");
        } else {
            $username = $_GET['name'];
            $sqlselect = "SELECT * FROM users WHERE username = '$username'";
            $resSelect = $db->mysqli->query($sqlselect);
            $userSelect = $resSelect->fetch_row();
            if ($userSelect == null) {
                header("Location: ./login.php");
            }
            $user = new User($userSelect[0],$userSelect[1],$userSelect[2],$userSelect[3],$userSelect[4],$userSelect[5], $userSelect[6],$userSelect[7],$userSelect[8]);
        }
    }

        $errorsPasswordUpdate = [];
        if (isset($_POST["update-password"])) {
            $oldPassword = $_POST["old-password"];
            $newPassword = $_POST["new-password"];
            $newPasswordConfirmed = $_POST["new-password-confirmed"];

            if (trim($oldPassword) === "" || trim($newPassword) === "" || trim($newPasswordConfirmed) === "" ) {
                $errorsPasswordUpdate[] = "Minden kötelezően kitöltendő mezőt ki kell tölteni!";
            }

            if ($newPassword !== $newPasswordConfirmed) {
                $errorsPasswordUpdate[] = "A két új jelszó nem egyezik!";
            }

            if (strlen($newPassword) < 5) {
                $errorsPasswordUpdate[] = "A jelszónak legalább 5 karakter hosszúnak kell lennie!";
            }

            if (!preg_match("/[A-Za-z]/", $newPassword) || !preg_match("/[0-9]/", $newPassword)) {
                $errorsPasswordUpdate[] = "A jelszónak tartalmaznia kell betűt és számjegyet is!";
            }

            if (!password_verify($oldPassword, $user->getPassword())) {
                $errorsPasswordUpdate[] = "A régi jelszó nem egyezik!";
            }

            if (password_verify($newPassword, $user->getPassword())) {
                $errorsPasswordUpdate[] = "Az új jelszó nem lehet megegyező a régi jelszóval!";
            }

            if (count($errorsPasswordUpdate) === 0) {
                $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
                $user->setPassword($newPasswordHashed, $_SESSION["userID"]);

                header("Location: profile.php?success=true");
            }
        }

    if(isset($_SESSION["ban_error"])){
        $ban_error = $_SESSION["ban_error"];
    }else{
        $ban_error[] = null;
    }
?>


<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $user->getUsername(); ?> profilja</title>
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <link rel="stylesheet" href="./css/style.css">
        <script src="./js/app.js" defer></script>
    </head>

    <body>
        <?php navigationGenerate("profile"); ?>

        <main>

            <?php

            if (isset($_GET["siker_delete"])) {
                echo "<div class='success' id='left-success'>Sikeres törlés!</div>";
            }

            if (count($ban_error) > 0 && isset($_SESSION["ban_error"])) {
                echo "<div class='errors'>";

                foreach ($ban_error as $be){
                    echo $be;
                }

                echo "</div>";
                unset($_SESSION["error"]);
            }


            ?>

            <div class="profile-container">
            <h1><?php echo $user -> getUsername(); ?> profilja</h1>

            <?php

                if ($ownProfile) {
                    if (isset($_GET["siker"])) {
                        echo "<div class='success'>A módisítás sikeres!</div>";
                    }

                    if (count($ban_error) > 0 && isset($_SESSION["ban_error"])) {
                        echo "<div class='errors'>";
                        foreach ($error as $err) {
                            echo "<p>" . $err . "</p>";
                        }
                        echo "</div>";
                    }

                    if (count($pic_error) > 0 && isset($_SESSION["profile_pic_error"])) {
                        echo "<div class='errors'>";
                        foreach ($pic_error as $pic_err) {
                            echo "<p>" . $pic_err . "</p>";
                        }
                        echo "</div>";
                    }

                    unset($_SESSION["errors"]);
                    unset($_SESSION["profile_pic_error"]);

                    echo
                    "<div class='profile-informations'>" .
                    "<form class='profile-form' action='php/profilePicture.php' method='post' enctype='multipart/form-data'>" .
                        "<div class='profile-picture-container'>" .
                            "<img class='img-rounded' height='200' src='profilepics/" . $user->getPicture() ."' alt='profile picture'>" .
                            "<label for='profile-picture'>Feltöltés</label>" .
                            "<input type='file' name='profile-picture' onchange='form.submit()' id='profile-picture'>" .
                        "</div>" .
                    "</form>" .
                    "<form class='profile-form' action='php/profileEdit.php' method='POST' autocomplete='off' enctype='multipart/form-data'>" .
                        "<label for='username'>Felhasználónév (min. 6 karakter):</label>" .
                        "<input type='text' name='username' id='username' maxlength='80' value='" .$user->getUsername() . "' required>" .
                        "<label for='email'>E-mail cím:</label>" .
                        "<input type='email' name='email' id='email' value='" . $user->getEmail() . "' required>" .
                        "<label for='password'>Aktuális jelszó:</label>" .
                        "<input type='password' name='aPassword' id='password' placeholder='Aktuális jelszó' required>" .
                        "<label for='birthday'>Születési dátum:</label>" .
                        "<input type='date' id='birthday' name='birthday' min='1900-01-01'>" .

                        "<input type='submit' name='update' value='Mentés'>" .
                        "<input type='submit' name='delete' value='Fiók törlése'>" .
                    "</form>" .

                    "<hr>" .

                    "<form class='profile-form' action='php/profileEdit.php' method='post'>".
                        "<label> " .
                        "<input type='checkbox' name='private_email' id='private_email' value='private_email'" . ($user->isEmailPrivate() ? 'checked' : '') . ">" .
                            "Privát email (Üres, ha publikust szeretnél)" .
                        "</label> <br>" .
                        "<label>" .
                            "<input type='checkbox' name='private_birthdate' id='private_birthdate' value='private_birthdate' ". ($user->isBirthDatePrivate() ? 'checked' : '') . ">" .
                        "Privát születésnap (Üres, ha publikust szeretnél)" .
                            "</label>" .
                        "<input type='submit' name='private_update' value='Privát adatok mentése'>" .
                    "</form>".
                    "<hr>" .
                    "<form class='profile-form password-update-form' action='profile.php' method='POST' autocomplete='off'>";

                            if (count($errorsPasswordUpdate) > 0) {
                                echo "<div class='errors-password'>";
                                foreach ($errorsPasswordUpdate as $error) {
                                    echo '<p>' . $error . '</p>';
                                }
                                echo '</div>';
                            }
                            if (isset($_GET['success'])) {
                                echo "<div class='success-password'>Sikeres jelszóváltoztatás!</div>";
                            }
                        echo
                                "<label for='old-password'>Aktuális jelszó:</label>" .
                                "<input type='password' name='old-password' id='old-password' placeholder='Aktuális jelszó' required>" .
                                "<label for='new-password'>Új jelszó: (opcionális, min. 6 karakter és szám)</label>" .
                                "<input type='password' name='new-password' id='new-password' placeholder='Új jelszó'>" .
                                "<label for='new-password-confirmed'>Új jelszó: újra</label>" .
                                "<input type='password' name='new-password-confirmed' id='new-password-confirmed' placeholder='Új jelszó újra'>" .
                                "<input type='submit' name='update-password' value='Jelszó megváltoztatása'>" .
                            "</form>" .
                        "</div>" .
                    "</div>";
                } else {
                    echo
                    "<div class='profile-information-container'>" .
                    "<div class='profile-information'>" .
                        "<p>Felhasználónév: " . $user->getUsername() . "</p>";
                        if (!$user->isEmailPrivate()) {
                            echo "<p>E-mail cím: " . $user->getEmail() . "</p>";
                        }
                        if (!$user->isBirthDatePrivate()) {
                            echo "<p>Születési dátum: " . $user->getBirthdate() . "</p>";
                        }
                    echo
                        "</div>" .
                            "<img width='360px' height='360px' class='profile-picture img-rounded' src='./profilePics/" . $user->getPicture() . "' alt='". $user->getUsername() . "' profil képe'>" .
                        "</div>";
                }
                if(isset($_SESSION["admin"])){
                    if(empty($username)){
                        $username = null;
                    }
                    echo "<form action='php/banUser.php' method='post' autocomplete='off'>
                            <input type='text' value='$username' name='username' hidden>
                            <button type='submit' name='delete_user_by_admin' class='delete_button' id='delete_user_by_admin'>Profil törlése</button>
                          </form>";
                }
            ?>
                <hr>

                <?php
                    if ($ownProfile) {
                        echo
                        "<div class='own-create-container'>" .
                            "<h2 class='own-recipes'>Saját receptek:</h2>" .
                            "<h4 class='create-recipe-link'><a href='./create-recipe.php'>Új recept hozzáadása</a></h4>" .
                        "</div>";
                    }
                ?>


                <?php
                    $db = new Database();
                    $id = $user->getID();
                    $sqlselect = "SELECT * FROM recipes WHERE user_id = '$id'";
                    $resSelect = $db->mysqli->query($sqlselect);
                    $recipes = $resSelect->fetch_all();


                    echo "<div class='recipe-list-container'>";
                    if (count($recipes) != 0) {
                        foreach ($recipes as $recipe) {

                            echo
                            "<div class='card-container'>" .
                                "<a href='./recipe.php?name=". slugify($recipe[2]) . "'>" .
                                    "<img src='./img/" . $recipe[3]. "' alt='" . $recipe[2] ."'>" .
                                    "<h3 class='recipe-name text-center'>". $recipe[2] . "</h3>" .
                                "</a>" .
                            "</div>";
                        }
                    } else {
                        echo "<p style='padding: 10px;'>Ez a felhasználó még nem töltött fel receptet</p>";
                    }
                    echo "</div>";


                ?>
                <hr>



            </div>
        </main>

    <?php footerGenerate(); ?>

    </body>
</html>
