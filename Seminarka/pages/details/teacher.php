<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!($teachersSQL = $conn->prepare("SELECT * FROM `pedagogove` WHERE `kod_pedagoga` = ?")) ||
    !($subjectsSQL = $conn->prepare("SELECT * FROM `pedagogove_predmety` WHERE `kod_pedagoga` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ".$_SESSION["index"]);
    exit;
}

$teachersSQL->bind_param("i", $_GET["show"]);
$teachersSQL->execute();
$teacher = $teachersSQL->get_result()->fetch_assoc();
$teachersSQL->close();

$subjectsSQL->bind_param("i", $_GET["show"]);
$subjectsSQL->execute();
$subjects = $subjectsSQL->get_result();
$subjectsSQL->close();

$conn->close();

echo '<h1 class="h3 mb-3 font-weight-normal">Detail pedagoga</h1>' . "\n";
echo '<table class="table table-bordered">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Jméno</th>' . "\n";
echo '<th class="align-text-left">' . $teacher["tituly_pred_jmenem"].' '.$teacher["jmeno"].' '.$teacher["prijmeni"].', '.$teacher["tituly_za_jmenem"].'</a></th>'."\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right" scope="row">Předměty</th>' . "\n";
echo '<th class="align-text-left">' . "\n";

foreach($subjects as $subject) {
    echo '<a href="?page=details&type=subject&show=' . $subject["zkratka_predmetu"] . '">' . $subject["zkratka_predmetu"] . '</a><br>' . "\n";
}

echo '</th>' . "\n";
echo '</tr>' . "\n";
echo '<tbody>' . "\n";
echo '</table>' . "\n";