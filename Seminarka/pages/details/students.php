<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!($infoQuerySQL = $conn->prepare("SELECT * FROM `zapsane_terminy` WHERE `id_terminu` = ?")) ||
    !($studentsSQL = $conn->prepare("SELECT * FROM `studenti`"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ".$_SESSION["index"]);
    exit;
}

$studentsList  = array();

$infoQuerySQL->bind_param("i", $_GET["show"]);
$infoQuerySQL->execute();
$infoQuery = $infoQuerySQL->get_result();
$infoQuerySQL->close();

$studentsSQL->execute();
$students = $studentsSQL->get_result();
$studentsSQL->close();
foreach ($students as $student) {
    $studentsList[$student["kod_studenta"]] = $student;
}

$conn->close();

echo '<h1 class="h3 mb-3 font-weight-normal">Studenti zapsaní na termínu</h1>' . "\n";
echo '<table class="table table-bordered">' . "\n";

foreach($infoQuery as $info) {
    $student = $studentsList[$info["kod_studenta"]];

    echo '<tr>' . "\n";
    echo '<th class="align-text-left col">' . "\n";

    if ($_SESSION["role"] === "pedagog") {
        echo '<a href="?page=details&type=student&show=' . $student["kod_studenta"] . '">' . $student["jmeno"] . ' ' . $student["prijmeni"] . '</a>' . "\n";
    } else {
        echo $student["jmeno"] . ' ' . $student["prijmeni"];
    }

    echo '</th>' . "\n";
    echo '</tr>' . "\n";
}

echo '</table>' . "\n";