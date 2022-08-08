<?php
    session_start();
    include "php/includes.php";
    require_once("php/connection.php");

    if (!isset($_SESSION["userID"])){
        header("location: ./login.php");
    }

    if(isset($_SESSION["error"])){
        $error = $_SESSION["error"];
    }else{
        $error[] = null;
    }
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Főoldal</title>
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <link rel="stylesheet" href="./css/style.css">
        <script src="./js/app.js" defer></script>
    </head>

    <body>
        <?php navigationGenerate("inbox"); ?>

        <main>
            <form class="message-send-form" action="php/messageSend.php" method="post" autocomplete="off">
            <?php
            if (isset($_GET["siker"])) {
                echo "<div class='success' id='left-success'>Megvan a felhasználó!</div>";
            }

            if (count($error) > 0 && isset($_SESSION["error"])) {
                echo "<div class='errors' id='left-errors'>";

                echo $error[0];

                echo "</div>";
                unset($_SESSION["error"]);
            }

            ?>
                <label class="required-label" for="cimzett">Címzett </label>
                <input class="new-message-to" type="text" id="cimzett" name="cimzett" value='<?php if(isset($_SESSION["cimzett"])) echo $_SESSION["cimzett"]; ?>' required>

                <label for="content">Szöveg</label>

                <textarea class="new-message-message" id="content" name="content"><?php if(isset($_SESSION["content"])) echo $_SESSION["content"]; ?></textarea>
                <div class="message-buttons">
                    <button class="new-message-user-check" type="submit" name="user_check" id="user_check">Címzett ellenőrzése</button>
                    <button class="new-message-send" type="submit" name="send_new_message" id="send_message">Üzenet elküldése</button>
                </div>
            </form>
        </main>

        <?php footerGenerate(); ?>
    </body>
</html>
