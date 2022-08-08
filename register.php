<?php
    session_start();
    require_once('php/connection.php');
    require_once('php/includes.php');

    if (isset($_SESSION['userID'])){
        header("Location: ./profile.php");
    }

    if(isset($_SESSION["reg_errors"])){
        $errors = $_SESSION["reg_errors"];
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
        <title>Regisztráció</title>
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <link rel="stylesheet" href="./css/style.css">
        <script src="./js/app.js" defer></script>
    </head>

    <body>
        <?php
        navigationGenerate("register");
        ?>

        <main>
            <div class="form-container">
                <?php
                if (count($errors) > 0 && isset($_SESSION["reg_errors"])) {
                    echo "<div class='errors'>";
                    foreach ($errors as $error) {
                        echo "<p>" . $error . "</p>";
                    }
                    echo "</div>";
                    unset($_SESSION["reg_errors"]);
                }
                ?>
                <h1>Regisztráció</h1>
                <form class="default-form register-form" action="php/registerValidator.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <label class="required-label" for="username">Felhasználónév (min. 6 karakter):</label>
                    <input type="text" name="username" id="username" maxlength="80" placeholder="Felhasználónév" value='<?php if(isset($_SESSION["reg_username"])) echo $_SESSION["reg_username"]; ?>' required>

                    <label class="required-label" for="email">E-mail cím:</label>
                    <input type="email" name="email" id="email" placeholder="email@email.com" value='<?php if(isset($_SESSION["reg_email"])) echo $_SESSION["reg_email"]; ?>' required>

                    <label class="required-label" for="password">Jelszó (min. 6 karakter és szám):</label>
                    <input type="password" name="password" id="password" placeholder="Jelszó" required>

                    <label class="required-label" for="password-check">Jelszó megerősítése:</label>
                    <input type="password" name="password-check" id="password-check" placeholder="Jelszó megerősítése" required>

                    <label for="birthdate">Születési dátum:</label>
                    <input type="date" id="birthdate" name="birthdate" min="1900-01-01" value='<?php if(isset($_SESSION["reg_bdate"])) echo $_SESSION["reg_bdate"]; ?>'>

                    <div class="form-btn-container">
                        <input type="submit" name="register" value="Regisztráció">
                        <input type="reset" name="reset" value="Reset">
                    </div>
                    <p class="required-footnote"><small> kötelező</small></p>
                </form>
            </div>
        </main>

        <?php footerGenerate();?>
    </body>
</html>
