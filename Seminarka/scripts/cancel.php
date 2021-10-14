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

if (!isset($_GET["examId"]) || $_GET["examId"] === "") {
    $_SESSION["error"] = "Neplatné ID termínu.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

require_once 'db.php';

$conn = connect();

if (!($resultsSQL = $conn->prepare("SELECT * FROM `zapsane_terminy` WHERE `id_terminu` = ? AND `kod_studenta` = ?")) ||
    !($deleteResultsSQL = $conn->prepare("DELETE FROM `vysledky` WHERE `id_vysledku` = ?")) ||
    !($deleteExamsSQL = $conn->prepare("DELETE FROM `zapsane_terminy` WHERE `id_terminu` = ? AND `kod_studenta` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ".$_SESSION["index"]);
    exit;
}

$resultsSQL->bind_param("ii", $_GET["examId"], $_SESSION["ID"]);
$resultsSQL->execute();
$result = $resultsSQL->get_result();
$resultsSQL->close();

if ($result->num_rows !== 1) {
    $_SESSION["error"] = "Neplatné ID termínu.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$resultId = $result->fetch_assoc()["id_vysledku"];

$deleteResultsSQL->bind_param("i", $resultId);
$deleteResultsSQL->execute();
$deleteResults = $deleteResultsSQL->affected_rows;
$deleteResultsSQL->close();

if ($deleteResults !== 1) {
    $_SESSION["error"] = "Nastala chyba při mazání výsledku termínu.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$deleteExamsSQL->bind_param("ii", $_GET["examId"], $_SESSION["ID"]);
$deleteExamsSQL->execute();
$deleteExams = $deleteExamsSQL->affected_rows;
$deleteExamsSQL->close();

$conn->close();

if ($deleteExams !== 1) {
    $_SESSION["error"] = "Nastala chyba při odepisování termínu.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$_SESSION["success"] = "Zkouška byla odepsána";
header("Location: " . $_SESSION["index"]);