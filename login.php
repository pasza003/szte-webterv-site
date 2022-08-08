<?php
    session_start();
    include "php/includes.php";
    require_once('php/connection.php');

    if(isset($_SESSION["errors"])){
        $errors[] = $_SESSION["errors"];
    }else{
        $errors[] = null;
    }
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bejelentkezés</title>
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <link rel="stylesheet" href="./css/style.css">
        <script src="./js/app.js" defer></script>
    </head>

    <body>
    <?php navigationGenerate("login"); ?>
        <main>
            <div class="form-container">

                <?php
                if (count($errors) > 0 && isset($_SESSION["errors"])) {
                    $length = count($errors);

                    echo "<div class='errors'>";

                    for ($i = 0; $i < $length;$i++) {
                        echo "<p>" . $errors[$i][$i] . "</p>";
                    }

                    echo "</div>";

                    unset($_SESSION["errors"]);
                }
                ?>

                <form class="default-form login-form" action="php/loginValidator.php" method="POST">
                    <fieldset>
                        <legend><h1>Bejelentkezés</h1></legend>
                        <label for="username">Felhasználónév:</label>
                        <input type="text" name="username" id="username" maxlength="80" placeholder="Felhasználónév" required>

                        <label for="password">Jelszó:</label>
                        <input type="password" name="password" id="password" placeholder="Jelszó" required>

                        <div class="form-btn-container">
                            <input type="submit" name="login" value="Bejelentkezés">
                        </div>
                    </fieldset>
                </form>
            </div>
        </main>

    <?php footerGenerate(); ?>

    </body>
</html>
