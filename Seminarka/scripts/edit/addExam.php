<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!isset($_POST["Subject_abbreviation"]) && $_POST["Subject_abbreviation"] === "") {
    $_SESSION["error"] = "Neplatný předmět.";
    header("Location: ../?page=edit&type=addExam");
    exit;
}
if (!isset($_POST["Room_abbreviation"]) && $_POST["Room_abbreviation"] === "") {
    $_SESSION["error"] = "Neplatná místnostt.";
    header("Location: ../?page=edit&type=addExam");
    exit;
}
if (!isset($_POST["Date_time"]) && $_POST["Date_time"] === "") {
    $_SESSION["error"] = "Neplatné datum.";
    header("Location: ../editDetails.php?type=addExam");
    exit;
}
if (strtotime($_POST["Date_time"]) < strtotime("+ 1 week")) {
    $_SESSION["error"] = "Do zkoušky musí zbývat alespoň týden";
    header("Location: ../?page=edit&type=addExam");
    exit;
}

if (strtotime($_POST["Date_time"]) > strtotime("+ 6 months")) {
    $_SESSION["error"] = "Termín musí proběhnout do půl roku.";
    header("Location: ../?page=edit&type=exam&edit=" . $_POST["ID"]);
    exit;
}

if (!($roomsSQL = $conn->prepare("SELECT * FROM `mistnosti` WHERE `zkratka_mistnosti` = ?")) ||
    !($examsSQL = $conn->prepare("SELECT MAX( id_terminu ) AS max FROM `vypsane_terminy`")) ||
    !($insertExamSQL = $conn->prepare("INSERT INTO `vypsane_terminy` (`id_terminu`, `zkratka_mistnosti`, `kod_pedagoga`, `zkratka_predmetu`, `datum_cas`, `max_pocet_prihlasenych`, `poznamka`) VALUES (?, ?, ?, ?, ?, ?, ?)"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ../?page=edit&type=addExam");
    exit;
}

$roomsSQL->bind_param("s", $_POST["Room_abbreviation"]);
$roomsSQL->execute();
$Max_Capacity = $roomsSQL->get_result()->fetch_assoc()["kapacita"];
$roomsSQL->close();

$examsSQL->bind_param("s", $_POST["Room_abbreviation"]);
$examsSQL->execute();
$ExamID = $examsSQL->get_result()->fetch_array(MYSQLI_ASSOC)['max'] + 1;
$examsSQL->close();

$insertExamSQL->bind_param("isissis", $ExamID, $_POST["Room_abbreviation"], $_SESSION["ID"], $_POST["Subject_abbreviation"], date('Y-m-d H:i:s', strtotime($_POST["Date_time"])), $Max_Capacity, $_POST["Note"]);
$insertExam = $insertExamSQL->execute();
$insertExamSQL->close();

if (!$insertExam) {
    $_SESSION["error"] = "Změny nebylo možné uložit.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$_SESSION["success"] = "Změny byly uloženy.";
header("Location: " . $_SESSION["index"]);
exit;