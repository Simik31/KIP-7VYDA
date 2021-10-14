<?php

session_start();
require_once 'scripts/db.php';

echo '<!DOCTYPE html>'."\n";
echo '<html lang="cs">'."\n";
echo '<head>'."\n";
echo '<title>Projekt 7VYDA</title>'."\n";
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />'."\n";
echo '<link rel="stylesheet" type="text/css" media="screen" href="css/'.($_COOKIE["theme"] ?? "light").'Theme.css" id="theme" />' . "\n";
echo '<script src="js/jQuery.js"></script>'."\n";
echo '<script src="js/bootstrap.bundle.min.js"></script>'."\n";
echo '<script src="js/themeSwitcher.js"></script>'."\n";
echo '<script src="js/hideAlerts.js"></script>'."\n";
echo '</head>'."\n";
echo '<body onload="waitAndHideAlert()">'."\n";
echo '<div class="container '.((isset($_SESSION["logged"]) && $_SESSION["logged"] === "In") ? ' position-absolute mt-3' : '').'">' . "\n";

if (isset($_SESSION["success"]) && $_SESSION["success"] !== "") {
    echo '<div onclick="waitAndHideAlert()" class="alert alert-success" role="alert" id="success">'."\n";
    echo $_SESSION["success"];
    echo '</div>'."\n";
    $_SESSION["success"] = "";
} else if (isset($_SESSION["error"]) && $_SESSION["error"] !== "") {
    echo '<div onload="waitAndHideAlert()" class="alert alert-danger" role="alert" id="error">'."\n";
    echo $_SESSION["error"];
    echo '</div>'."\n";
    $_SESSION["error"] = "";
} else {
    echo '<div class="alert placeholder"></div>'."\n";
}

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    require_once 'pages/login.php';
} else {
    $conn = connect();
    if (!isset($_GET["page"])) {
        require_once 'pages/' . $_SESSION["role"] . ".php";
    } else {
        echo '<h1 class="h3 mb-3 font-weight-normal">' . "\n";
        echo '<a href="' . $_SESSION["index"] . '">' . "\n";
        echo '<button class="btn float-left btn-primary col-sm-2">Domů</button>' . "\n";
        echo '</a>' . "\n";
        echo $_SESSION["Name"] . "\n";
        echo '<a href="scripts/Logout.php">' . "\n";
        echo '<button class="btn float-right btn-primary col-sm-2">Odhlásit se</button>' . "\n";
        echo '</a>' . "\n";
        echo '</h1>' . "\n";

        if ($_GET["page"] === "details" && in_array($_GET["type"], array("result", "results", "room", "student", "students", "subject", "teacher"))) {
            require_once 'pages/details/' . $_GET["type"] . '.php';
        } else if ($_GET["page"] === "edit" && in_array($_GET["type"], array("addExam", "exam", "result", "room", "subject"))) {
            if ($_SESSION["role"] !== "pedagog") {
                $_SESSION["error"] = "Na požadovanou stránku má přistup pouze pedagog.";
                header("Location: " . $_SESSION["index"]);
                exit;
            }
            require_once 'pages/edit/' . $_GET["type"] . '.php';

            echo '<button class="btn btn-primary col-sm-2" type="submit">Uložit</button>' . "\n";
            echo '</form>' . "\n";

            if ($_GET["type"] === "exam") {
                echo '<form class="form" action="scripts/deleteExam.php" method="post">' . "\n";
                echo '<input type="hidden" name="examID" value="' . $_GET["edit"] . '">' . "\n";
                echo '<button class="btn btn-danger col-sm-2" type="submit">Smazat termín</button>' . "\n";
                echo '</form>' . "\n";
            }
        } else {
            $_SESSION["error"] = "Stránka nenalezena.";
            header("Location: " . $_SESSION["index"]);
            exit;
        }
    }
}

echo '<div class="alert placeholder"></div>'."\n";
echo '<div id="wz-ad">'."\n";
require_once 'ad.html';
echo '</div>'."\n";
echo '</div>'."\n";
echo '<span onclick="themeSwitch()" id="switch" data-toggle="tooltip" data-placement="left" title="Změnit barevné schéma"></span>'."\n";
echo '</body>'."\n";
echo '</html>'."\n";