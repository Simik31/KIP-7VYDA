<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if($_SESSION["role"] !== "pedagog") {
    $_SESSION["error"] = "Na požadovanou stránku má přistup pouze pedagog.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

if (!($infoQuerySQL = $conn->prepare("SELECT * FROM `zapsane_terminy` WHERE `id_terminu` = ?")) ||
    !($studentsSQL = $conn->prepare("SELECT * FROM `studenti`")) ||
    !($resultsSQL = $conn->prepare("SELECT * FROM `vysledky`"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ".$_SESSION["index"]);
    exit;
}

$studentsList = array();
$resultsList = array();

$infoQuerySQL->bind_param("i", $_GET["examId"]);
$infoQuerySQL->execute();
$infoQuery = $infoQuerySQL->get_result();
$infoQuerySQL->close();

$studentsSQL->execute();
$students = $studentsSQL->get_result();
$studentsSQL->close();
foreach ($students as $student) {
    $studentsList[$student["kod_studenta"]] = $student["jmeno"] . " " . $student["prijmeni"];
}

$resultsSQL->execute();
$results = $resultsSQL->get_result();
$resultsSQL->close();
foreach ($results as $result) {
    $resultsList[$result["id_vysledku"]] = $result["popis"];
}

$conn->close();

echo '<h1 class="h3 mb-3 font-weight-normal">Hodnocení studentů</h1>' . "\n";
echo '<table class="table table-bordered">' . "\n";
echo '<thead>' . "\n";
echo '<tr>' . "\n";
echo '<th class="col" scope="col">Student</th>' . "\n";
echo '<th class="align-text-left" scope="col">Hodnocení</th>' . "\n";
echo '</tr>' . "\n";
echo '</thead>' . "\n";
echo '<tbody>' . "\n";

foreach ($infoQuery as $info) {
    $result = $resultsList[$info["id_vysledku"]];
    echo '<tr>' . "\n";
    echo '<th class="align-text-right col">' . $studentsList[$info["kod_studenta"]] . '</th>' . "\n";
    echo '<th class="align-text-left">' . "\n";
    echo '<a href="?page=edit&type=result&show=' . $info["id_vysledku"] . '&return=' . $_GET["examId"] . '">'.($result === "" ? "Přidat hodnocení" : $result).'</a>' . "\n";
    echo '</th>' . "\n";
    echo '</tr>' . "\n";
}
echo '</tbody>' . "\n";
echo '</table>' . "\n";