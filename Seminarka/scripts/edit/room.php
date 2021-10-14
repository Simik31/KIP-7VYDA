<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!isset($_POST["ID"]) || $_POST["ID"] === "") {
    $_SESSION["error"] = "Neplatné ID místnosti.";
    header("Location: ../index.php");
    exit;
}

if (!isset($_POST["Description"]) || $_POST["Description"] === "") {
    $_SESSION["error"] = "Neplatný popis.";
    header("Location: ../?page=edit&type=room&show=" . $_POST["ID"]);
    exit;
}

if (!isset($_POST["Capacity"]) || $_POST["Capacity"] === "") {
    $_SESSION["error"] = "Neplatná kapacita.";
    header("Location: ../?page=edit&type=room&show=" . $_POST["ID"]);
    exit;
}

if (!($roomsSQL = $conn->prepare("UPDATE `mistnosti` SET `popis` = ?, `kapacita`= ? WHERE `zkratka_mistnosti` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ../?page=edit&type=room&show=" . $_POST["ID"]);
    exit;
}

$roomsSQL->bind_param("sii", $_POST["Description"], $_POST["Capacity"], $_POST["ID"]);
$updateRoom = $roomsSQL->execute();
$roomsSQL->close();

if ($updateRoom) {
    $_SESSION["success"] = "Změny byly uloženy.";
} else {
    $_SESSION["error"] = "Změny nebylo možné uložit.";
}