<?php
    require_once("php/connection.php");
    require_once "php/includes.php";
    require_once("php/messagesSelect.php");

    $dataBase = new Database();

    $ms = new messagesSelect();


    $friends_array = $ms ->friends();

    $id = $_SESSION["admin"] ?? $_SESSION["userID"];

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


    <div class="friends-container">
        <a href="new-message.php"><button type="button" id="new-message">Új üzenet</button></a>

        <h2>"Barátok"</h2>
        <table class="top-uploaders-table friends">
            <tr>
                <th id="kitol">Felhasználó</th>
            </tr>
                <?php

                if(!empty($friends_array)){

                foreach ($friends_array as $fArray) {

                    $friend = implode(" ",$fArray);
                ?>

            <tr>
                <td><a href="chat.php?user=<?php echo $friend ?>"><?php echo $friend  ?></a></td>

            </tr>

            <?php
            }
                }else{
                    ?>
            <td>Még senki sem küldött üzenetet :(</td>
            <?php
                }
            ?>
        </table>
    </div>
</main>

<?php footerGenerate(); ?>

</body>

</html>
