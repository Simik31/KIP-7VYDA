<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!isset($_POST["ID"]) || $_POST["ID"] === "") {
    $_SESSION["error"] = "Neplatné ID hodnocení.";
    header("Location: ../index.php");
    exit;
}

if (!($resultQL = $conn->prepare("UPDATE `vysledky` SET `popis`= ? WHERE `id_vysledku` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ".$_SESSION["index"]);
    exit;
}

$resultQL->bind_param("si", $_POST["Description"], $_POST["ID"]);
$updateResult = $resultQL->execute();
$resultQL->close();

if($updateResult) {
    $_SESSION["success"] = "Změny byly uloženy.";
} else {
    $_SESSION["error"] = "Změny nebylo možné uložit.";
}