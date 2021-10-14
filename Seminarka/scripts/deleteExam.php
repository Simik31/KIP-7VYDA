<?php

session_start();

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../index.php");
    exit;
}

if($_SESSION["role"] !== "pedagog") {
    $_SESSION["error"] = "Na požadovanou stránku má přistup pouze pedagog.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

if (!isset($_POST["examID"]) || $_POST["examID"] === "") {
    $_SESSION["error"] = "Neplatné ID termínu.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

require_once 'db.php';

$conn = connect();

if (!($examsSQL = $conn->prepare("SELECT * FROM `zapsane_terminy` WHERE `id_terminu` = ?")) ||
    !($deleteExamSQL = $conn->prepare("DELETE FROM `vypsane_terminy` WHERE `id_terminu` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ".$_SESSION["index"] . "?page=edit&type=exam&edit=" . $_POST["examID"]);
    exit;
}

$examsSQL->bind_param("i", $_POST["examID"]);
$examsSQL->execute();
$students = $examsSQL->get_result()->num_rows;
$examsSQL->close();

if ($students !== 0) {
    $_SESSION["error"] = "Lze smazat pouze prázdný termín.";
    header("Location: " . $_SESSION["index"] . "?page=edit&type=exam&edit=" . $_POST["examID"]);
    exit;
}

$deleteExamSQL->bind_param("i", $_POST["examID"]);
$deleteExamSQL->execute();
$deleteExam = $deleteExamSQL->affected_rows;
$deleteExamSQL->close();

if ($deleteExam !== 1) {
    $_SESSION["error"] = "Termín nebylo možné smazat.";
    header("Location: " . $_SESSION["index"] . "?page=edit&type=exam&edit=" . $_POST["examID"]);
    exit;
}

$conn->close();

$_SESSION["success"] = "Termín byl smazán.";
header("Location: " . $_SESSION["index"]);