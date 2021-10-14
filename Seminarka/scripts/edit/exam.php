<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!isset($_POST["ID"]) || $_POST["ID"] === "") {
    $_SESSION["error"] = "Neplatné ID termínu.";
    header("Location: ../index.php");
    exit;
}

if (!isset($_POST["Room_abbreviation"]) || $_POST["Room_abbreviation"] === "") {
    $_SESSION["error"] = "Neplatná místnost.";
    header("Location: ../?page=edit&type=exam&edit=" . $_POST["ID"]);
    exit;
}

if (!isset($_POST["Date_time"]) || $_POST["Date_time"] === "") {
    $_SESSION["error"] = "Neplatné datum.";
    header("Location: ../?page=edit&type=exam&edit=" . $_POST["ID"]);
    exit;
}

if (strtotime($_POST["Date_time"]) < strtotime("+ 1 week")) {
    $_SESSION["error"] = "Do zkoušky musí zbývat alespoň týden";
    header("Location: ../?page=edit&type=exam&edit=" . $_POST["ID"]);
    exit;
}

if (strtotime($_POST["Date_time"]) > strtotime("+ 6 months")) {
    $_SESSION["error"] = "Termín musí proběhnout do půl roku.";
    header("Location: ../?page=edit&type=exam&edit=" . $_POST["ID"]);
    exit;
}

if (!($roomsSQL = $conn->prepare("SELECT * FROM `mistnosti` WHERE `zkratka_mistnosti` = ?")) ||
    !($updateExamSQL = $conn->prepare("UPDATE `vypsane_terminy` SET `zkratka_mistnosti` = ?, `datum_cas` = ?, `max_pocet_prihlasenych` = ?, `poznamka` = ? WHERE `id_terminu` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ../?page=edit&type=exam&edit=" . $_POST["ID"]);
    exit;
}

$date = date('Y-m-d H:i:s', strtotime($_POST["Date_time"]));

$roomsSQL->bind_param("s", $_POST["Room_abbreviation"]);
$roomsSQL->execute();
$Max_Capacity = $roomsSQL->get_result()->fetch_assoc()["kapacita"];
$roomsSQL->close();

$updateExamSQL->bind_param("ssisi", $_POST["Room_abbreviation"], $date, $Max_Capacity, $_POST["Note"], $_POST["ID"]);
$updateExam = $updateExamSQL->execute();
$updateExamSQL->close();

if (!$updateExam) {
    $_SESSION["error"] = "Změny nebylo možné uložit.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$_SESSION["success"] = "Změny byly uloženy.";
header("Location: " . $_SESSION["index"]);
exit;