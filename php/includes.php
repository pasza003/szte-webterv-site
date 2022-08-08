<?php

function navigationGenerate(string $currentPage) {
    echo 
    "<nav class='navbar'>" .
    "<a class='brand' href='./index.php'>Receptoldal</a>" .
    "<ul class='nav-menu'>" .
        "<li class='nav-item'><a class='nav-link " . ($currentPage === "index" ? " active" : "") . "' href='./index.php'>Főoldal</a></li>" .
        "<li class='nav-item'><a class='nav-link " . ($currentPage === "recipes" ? " active" : "") . "' href='./recipes.php'>Receptek</a></li>";
        if (isset($_SESSION["userID"]) || isset($_SESSION["admin"])) {

            echo
                "<li class='nav-item'><a class='nav-link " . ($currentPage === "profile" ? " active" : "") . "' href='profile.php'>Profil</a></li>" .
                "<li class='nav-item'><a class='nav-link " . ($currentPage === "create-recipe" ? " active" : "") . "' href='create-recipe.php'>Recept feltöltése</a></li>" .
                "<li class='nav-item'><a class='nav-link " . ($currentPage === "inbox" ? " active" : "") . "' href='inbox.php'>Üzenetek</a></li>" .
                "<li class='nav-item'><a class='nav-link' href='php/logout.php'>Kijelentkezés</a></li>";
            if(isset($_SESSION["admin"])){
                echo
                    "<li class='nav-item' style='color: red'>Admin profil</li>";
            }

        } else {
            echo
                "<li class='nav-item'><a class='nav-link " . ($currentPage === "login" ? " active" : "") . "' href='login.php'>Bejelentkezés</a></li>" .
                "<li class='nav-item'><a class='nav-link " . ($currentPage === "register" ? " active" : "") . "' href='register.php'>Regisztráció</a></li>";
        }
        echo "</ul>" .
            "<div class='burger'>" .
                "<span class='bar'></span>" .
                "<span class='bar'></span>" .
                "<span class='bar'></span>" .
            "</div>" .
    "</nav>";
}

function footerGenerate() {
    echo
        "<footer>" .
            "<ul>" .
                "<li><a href='index.php'>Főoldal</a></li>" .
                "<li><a href='recipes.php'>Receptek</a></li>";
                if (isset($_SESSION["userID"]) || isset($_SESSION["admin"])) {
                    echo
                        "<li><a href='profile.php'>Profil</a></li>" .
                        "<li><a href='php/logout.php'>Kijelentkezés</a></li>";
                } else {
                    echo
                        "<li><a href='login.php'>Bejelentkezés</a></li>" .
                        "<li><a href='register.php'>Regisztráció</a></li>";

                }
            echo
            "</ul>" .
            "<p class='copyright'>Copyright &copy; 2022 Receptoldal</p>" .
        "</footer>";
}

function slugify($text, string $divider = '-') {
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
    return 'n-a';
    }

    return $text;
}