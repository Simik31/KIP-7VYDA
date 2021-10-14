<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!($studentsSQL = $conn->prepare("SELECT * FROM `studenti` WHERE `kod_studenta` = ?")) ||
    !($examsSQL = $conn->prepare("SELECT * FROM `studenti_predmety` WHERE `kod_studenta` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ".$_SESSION["index"]);
    exit;
}

$studentsSQL->bind_param("i", $_GET["show"]);
$studentsSQL->execute();
$student = $studentsSQL->get_result()->fetch_assoc();
$studentsSQL->close();

$examsSQL->bind_param("i", $_GET["show"]);
$examsSQL->execute();
$exams = $examsSQL->get_result();
$examsSQL->close();

$conn->close();

echo '<h1 class="h3 mb-3 font-weight-normal">Detail studenta</h1>' . "\n";
echo '<table class="table table-bordered">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Jméno</th>' . "\n";
echo '<th class="align-text-left">' . $student["jmeno"] . ' ' . $student["prijmeni"] . '</th>' . "\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right" scope="row">Předměty</th>' . "\n";
echo '<th class="align-text-left">' . "\n";

foreach ($exams as $exam) {
    echo '<a href="?page=details&type=subject&show=' . $exam["zkratka_predmetu"] . '">' . $exam["zkratka_predmetu"] . '</a><br>' . "\n";
}

echo '</th>' . "\n";
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";