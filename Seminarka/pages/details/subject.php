<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!(   $subjectSQL = $conn->prepare("SELECT * FROM `predmety`            WHERE `zkratka_predmetu` = ?")) ||
    !($teachersIDSQL = $conn->prepare("SELECT * FROM `pedagogove_predmety` WHERE `zkratka_predmetu` = ?")) ||
    !(  $teachersSQL = $conn->prepare("SELECT * FROM `pedagogove`")) ||
    !(  $studentsSQL = $conn->prepare("SELECT * FROM `studenti_predmety`   WHERE `zkratka_predmetu` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ".$_SESSION["index"]);
    exit;
}

$teachersList = array();

$subjectSQL->bind_param("s", $_GET["show"]);
$subjectSQL->execute();
$subject = $subjectSQL->get_result()->fetch_assoc();
$subjectSQL->close();

$teachersIDSQL->bind_param("s", $_GET["show"]);
$teachersIDSQL->execute();
$teachersID = $teachersIDSQL->get_result();
$teachersIDSQL->close();
foreach ($teachersID as $teacherID) {
    $teachersList[$teacherID["kod_pedagoga"]] = "";
}

$teachersSQL->execute();
$teachers = $teachersSQL->get_result();
$teachersSQL->close();

$studentsSQL->bind_param("s", $subject["zkratka_predmetu"]);
$studentsSQL->execute();
$studentsCount = $studentsSQL->get_result()->num_rows;
$studentsSQL->close();

$conn->close();

echo '<h1 class="h3 mb-3 font-weight-normal">Detail předmětu</h1>' . "\n";
echo '<table class="table table-bordered">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Zkratka předmětu</th>' . "\n";
echo '<th class="align-text-left">' . $subject["zkratka_predmetu"] . '</th>' . "\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Název předmětu</th>' . "\n";
echo '<th class="align-text-left">' . $subject["nazev"] . '</th>' . "\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Vyučující</th>' . "\n";
echo '<th class="align-text-left">' . "\n";

foreach ($teachers as $teacher) {
    if(isset($teachersList[$teacher["kod_pedagoga"]])) {
        echo '<a href="?page=details&type=teacher&show='.$teacher["kod_pedagoga"].'">'.$teacher["tituly_pred_jmenem"].' '.$teacher["jmeno"].' '.$teacher["prijmeni"].', '.$teacher["tituly_za_jmenem"].'</a><br>'."\n";
    }
}

echo '</th>' . "\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Počet studentů</th>' . "\n";
echo '<th class="align-text-left">' . $studentsCount . '</th>' . "\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Kredity</th>' . "\n";
echo '<th class="align-text-left">' . $subject["pocet_kreditu"] . '</th>' . "\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Hodin přednášek</th>' . "\n";
echo '<th class="align-text-left">' . $subject["pocet_hodin_prednasek"] . '</th>' . "\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Hodin cvičení</th>' . "\n";
echo '<th class="align-text-left">' . $subject["pocet_hodin_cviceni"] . '</th>' . "\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Ukončení</th>' . "\n";
echo '<th class="align-text-left">' . ($subject["ukonceni"] === 'Za' ? 'Zápočet' : 'Zkouška') . '</th>' . "\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Anotace</th>' . "\n";
echo '<th class="align-text-left">'."\n";
echo  $subject["anotace"]."\n";
echo '</th>'."\n";
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";

if($_SESSION["role"] === "pedagog") {
    echo '<a href="?page=edit&type=' . $_GET["type"] . '&edit=' . $_GET["show"] . '">' . "\n";
    echo '<button class="btn btn-primary col-sm-2">Upravit předmět</button>' . "\n";
    echo '</a>' . "\n";
}