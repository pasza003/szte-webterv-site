<?php
    require_once('php/connection.php');
    require_once('php/includes.php');
    require_once("php/messagesSelect.php");
    require_once("php/message.php");

    $db = new Database();

    $username = $_GET["user"];

    $_SESSION["chat_username"] = $username;
    $username_id = $db -> get_user_id($username);

    $_SESSION["chat_username_id"] = $username_id;

    $messageClass = new messagesSelect();
    $messageArray = $messageClass ->messageArray($username_id);
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Főoldal</title>
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <link rel="stylesheet" href="css/style.css">
        <script src="./js/app.js" defer></script>
    </head>

    <body>
        <?php navigationGenerate("inbox"); ?>

        <main>
            <h2>Üzenetek <?php echo $username ?> felhasználóval</h2>
            <table class="top-uploaders-table message-table">
                <tr>
                    <th id="kinek">Üzenet</th>
                </tr>
                <?php
                if(!empty($messageArray)){
                    foreach ($messageArray as $mArray) {

                        $message = $mArray -> getMessage();
                        $message_username = $mArray -> getSenderUsername();
                        ?>

                        <tr>
                            <?php

                                if($message_username == $username){
                                    echo "
                                        <td id='message-left'>$message</td>";

                                }else{
                                    echo "
                                        <td id='message-right'>$message</td>";

                                }

                                ?>
                        </tr>
                        <?php
                    }
                }else{
                    ?>
                    <td>Ez a felhasználó még nem küldött neked üzenetet. Mit keresel itt?</td>
                    <?php
                }
                ?>
            </table>


            <div class="message-send-form">
                <form action="php/messageSend.php" method="post" autocomplete="off">
                    <input type="text" id="cimzett" name="cimzett" value="" hidden>

                    <label for="content">Szöveg</label>
                    <br>

                    <textarea id="content" name="content">

                </textarea>
                    <br>
                    <div class="message-buttons">
                        <button type="submit" name="send_message" id="send_message">Üzenet elküldése</button>
                    </div>
                </form>
            </div>
        </main>

        <?php footerGenerate(); ?>

    </body>

</html>
