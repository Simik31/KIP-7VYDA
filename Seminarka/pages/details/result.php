<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!($resultsSQL = $conn->prepare("SELECT * FROM `vysledky` WHERE `id_vysledku` = ?")) ||
    !($examsSQL = $conn->prepare("SELECT * FROM `zapsane_terminy` WHERE `id_vysledku` = ?")) ||
    !($teacherIDsSQL = $conn->prepare("SELECT * FROM `vypsane_terminy` WHERE `id_terminu` = ?")) ||
    !($teachersSQL = $conn->prepare("SELECT * FROM `pedagogove` WHERE `kod_pedagoga` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ".$_SESSION["index"]);
    exit;
}

$resultsSQL->bind_param("i", $_GET["show"]);
$resultsSQL->execute();
$result = $resultsSQL->get_result()->fetch_assoc();
$resultsSQL->close();

$examsSQL->bind_param("i", $_GET["show"]);
$examsSQL->execute();
$exam = $examsSQL->get_result()->fetch_assoc()["id_terminu"];
$examsSQL->close();

$teacherIDsSQL->bind_param("i", $exam);
$teacherIDsSQL->execute();
$teacherID = $teacherIDsSQL->get_result()->fetch_assoc()["kod_pedagoga"];
$teacherIDsSQL->close();

$teachersSQL->bind_param("i", $teacherID);
$teachersSQL->execute();
$teacher = $teachersSQL->get_result()->fetch_assoc();
$teachersSQL->close();

$conn->close();

echo '<h1 class="h3 mb-3 font-weight-normal">Detail hodnocení</h1>' . "\n";
echo '<table class="table table-bordered">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Zkoušející</th>' . "\n";
echo '<th class="align-text-left"><a href="?page=details&type=teacher&show=' . $teacherID . '">' . $teacher["tituly_pred_jmenem"].' '.$teacher["jmeno"].' '.$teacher["prijmeni"].', '.$teacher["tituly_za_jmenem"].'</a></th>'."\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right" scope="row">Popis</th>' . "\n";
echo '<th class="align-text-left">' . $result["popis"] . '</th>' . "\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right" scope="row">Typ</th><th class="align-text-left">' . ($result["typ"] === "Za" ? "Zápočet" : "Zkouška") . '</th>' . "\n";
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";

if($_SESSION["role"] === "pedagog") {
    echo '<a href="?page=edit&type=' . $_GET["type"] . '&edit=' . $_GET["show"] . '">' . "\n";
    echo '<button class="btn btn-primary col-sm-2">Upravit hodnocení</button>' . "\n";
    echo '</a>' . "\n";
}