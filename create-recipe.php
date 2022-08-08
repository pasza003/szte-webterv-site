<?php
    session_start();
    require_once('php/connection.php');
    require_once('php/includes.php');

    if(!isset($_SESSION["admin"])) {
        if (!isset($_SESSION["userID"])) {
            header("location: login.php");
        }
    }

    if(isset($_SESSION["create_recipe_errors"])){
        $recipe_errors = $_SESSION["create_recipe_errors"];
    }else{
        $recipe_errors[] = null;
    }

?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recept hozzáadása</title>
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <link rel="stylesheet" href="./css/style.css">
        <script src="./js/app.js" defer></script>
    </head>

    <body>
        <?php
            navigationGenerate("create-recipe");
        ?>

        <main>
            <div class="form-container">
                <?php

                if (count($recipe_errors) > 0 && isset($_SESSION["create_recipe_errors"])) {
                    echo "<div class='errors'>";
                    foreach ($recipe_errors as $error) {
                        echo "<p>" . $error . "</p>";
                    }
                    echo "</div>";
                    unset($_SESSION["create_recipe_errors"]);
                }
                ?>

                <h1>Új recept hozzáadása</h1>
                <form class="default-form create-recipe-form" action="php/createRecipeValidator.php" method="POST" enctype="multipart/form-data">
                    <label class="required-label" for="recipe-name">Recept neve:</label>
                    <input type="text" name="recipe-name" id="recipe-name" maxlength="80" placeholder="Recept neve" required>

                    <label class="required-label" for="portion">Adag:</label>
                    <input type="number" name="portion" id="portion" value="4" min="0" required>

                    <label class="required-label" for="time">Idő (perc):</label>
                    <input type="number" name="time" id="time" value="120" min="0" required>

                    <label class="required-label" for="recipe-ingredients">Recept hozzávalók: (A hozzávalókat enterrel válaszd el!)</label>
                    <textarea  required id="recipe-ingredients" name="recipe-ingredients" rows="6"
placeholder="1 kg liszt
500 g burgonya">
</textarea>

                    <label class="required-label" for="recipe-instructions">Elkészítés:</label>
                    <textarea id="recipe-instructions" name="recipe-instructions" rows="6"></textarea>

                    <label for="recipe-video-link">Recept videó link:</label>
                    <input type="text" name="recipe-video-link" id="recipe-video-link" maxlength="80" placeholder="https://youtube.com/embed/*watch utáni karaktersorozat*">

                    <label class="required-label" for="recipe-picture">Kép:</label>
                    <input type="file" name="recipe-picture" id="recipe-picture" >

                    <div class="form-btn-container center">
                        <input type="submit" name="create-recipe" value="Recept hozzáadása">
                    </div>
                    <p class="required-footnote"><small> kötelező</small></p>
                </form>
            </div>
        </main>

        <?php footerGenerate();?>

    </body>
</html>
