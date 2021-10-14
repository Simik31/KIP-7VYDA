<?php

session_start();

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../index.php");
    exit;
}

if ($_SESSION["role"] !== "student") {
    $_SESSION["error"] = "Na požadovanou stránku má přistup pouze student.";
    header("Location: ".$_SESSION["index"]);
    exit;
}

if (!isset($_GET["examId"]) && $_GET["examId"] === "") {
    $_SESSION["error"] = "Neplatné ID termínu.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

require_once 'db.php';

$conn = connect();

if (!($examsSQL = $conn->prepare("SELECT * FROM `vypsane_terminy` WHERE `id_terminu` = ?")) ||
    !($roomsSQL = $conn->prepare("SELECT * FROM `mistnosti` WHERE `zkratka_mistnosti` = ?")) ||
    !($studentsSQL = $conn->prepare("SELECT * FROM `zapsane_terminy` WHERE `id_terminu` = ?")) ||
    !($examIDSQL = $conn->prepare("SELECT MAX( id_vysledku ) AS max FROM `vysledky` ")) ||
    !($insetExamSQL = $conn->prepare("INSERT INTO `zapsane_terminy` (`id_terminu`, `kod_studenta`, `id_vysledku`) VALUES (?, ?, ?)")) ||
    !($resultIDSQL = $conn->prepare("SELECT * FROM `predmety` WHERE `zkratka_predmetu` = ?")) ||
    !($insertResultSQL = $conn->prepare("INSERT INTO `vysledky` (`id_vysledku`, `popis`, `typ`) VALUES (?, '', ?)"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ".$_SESSION["index"]);
    exit;
}

$examsSQL->bind_param("i", $_GET["examId"]);
$examsSQL->execute();
$exam = $examsSQL->get_result()->fetch_assoc();
$examsSQL->close();

$roomsSQL->bind_param("s", $exam["zkratka_mistnosti"]);
$roomsSQL->execute();
$capacity = $roomsSQL->get_result()->fetch_assoc()["kapacita"];
$roomsSQL->close();

$studentsSQL->bind_param("i", $_GET["examId"]);
$studentsSQL->execute();
$studentsInRoom = $studentsSQL->get_result()->num_rows;
$studentsSQL->close();

if ($studentsInRoom >= $capacity) {
    $_SESSION["error"] = "Zkouška je již plně obsazena.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$examIDSQL->execute();
$Result_ID = $examIDSQL->get_result()->fetch_array(MYSQLI_ASSOC)['max'] + 1;
$examIDSQL->close();

$insetExamSQL->bind_param("iii", $_GET["examId"], $_SESSION["ID"], $Result_ID);
$insetExamSQL->execute();
$insetExam = $insetExamSQL->affected_rows;
$insetExamSQL->close();

if ($insetExam !== 1) {
    $_SESSION["error"] = "Tuto zkoušku již máte zapsánu.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$resultIDSQL->bind_param("s", $exam["zkratka_predmetu"]);
$resultIDSQL->execute();
$Result_Type = $resultIDSQL->get_result()->fetch_assoc()["ukonceni"];
$resultIDSQL->close();

$insertResultSQL->bind_param("is", $Result_ID, $Result_Type);
$insertResultSQL->execute();
$insertResult = $insertResultSQL->affected_rows;
$insertResultSQL->close();

if ($insertResult !== 1) {
    $_SESSION["error"] = "Zkoušku nebylo možné zapsat.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$conn->close();

$_SESSION["success"] = "Zkouška byla zapsána.";
header("Location: " . $_SESSION["index"]);