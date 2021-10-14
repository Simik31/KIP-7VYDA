<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

$resultID = $_GET["show"] ?? $_GET["edit"];

if (isset($_GET["return"])) {
    $return = $_GET["return"];
} else {
    if (!($subjectsSQL = $conn->prepare("SELECT * FROM `zapsane_terminy` WHERE `id_vysledku` = ?"))) {
        $_SESSION["error"] = "Chyba načítání databáze.";
        header("Location: " . $_SESSION["index"]);
        exit;
    }

    $subjectsSQL->bind_param("i", $resultID);
    $subjectsSQL->execute();
    $return = $subjectsSQL->get_result()->fetch_assoc()["id_terminu"];
    $subjectsSQL->close();
}

if (!($resultsSQL = $conn->prepare("SELECT * FROM `vysledky` WHERE `id_vysledku` = ?")) ||
    !($examsSQL = $conn->prepare("SELECT * FROM `zapsane_terminy` WHERE `id_vysledku` = ?")) ||
    !($studentsSQL = $conn->prepare("SELECT * FROM `studenti` WHERE `kod_studenta` = ?")) ||
    !($allExamsSQL = $conn->prepare("SELECT * FROM `vypsane_terminy` WHERE `id_terminu` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$resultsSQL->bind_param("i", $resultID);
$resultsSQL->execute();
$result = $resultsSQL->get_result()->fetch_assoc();
$resultsSQL->close();

$examsSQL->bind_param("i", $resultID);
$examsSQL->execute();
$exam = $examsSQL->get_result()->fetch_assoc();
$examsSQL->close();

$studentsSQL->bind_param("i", $exam["kod_studenta"]);
$studentsSQL->execute();
$student = $studentsSQL->get_result()->fetch_assoc();
$studentsSQL->close();

$allExamsSQL->bind_param("i", $exam["id_terminu"]);
$allExamsSQL->execute();
$allExam = $allExamsSQL->get_result()->fetch_assoc();
$allExamsSQL->close();

$conn->close();

echo '<h1 class="h3 mb-3 font-weight-normal">Úprava hodnocení</h1>' . "\n";
echo '<form class="form" action="scripts/editDetails.php" method="post">' . "\n";
echo '<input type="hidden" name="type" value="' . $_GET["type"] . '">' . "\n";
echo '<input type="hidden" id="ID" class="form-control" name="ID" value="' . $resultID . '">' . "\n";
echo '<input type="hidden" id="return" class="form-control" name="return" value="' . $return . '">' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Student" class="align-text-right col-sm-2 col-form-label">Student</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="Student" class="form-control" name="Student" value="' . $student["jmeno"] . ' ' . $student["prijmeni"] . '" disabled required>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="ExamType" class="align-text-right col-sm-2 col-form-label">Zakončení</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="ExamType" class="form-control" name="ExamType" value="' . ($result["typ"] === "Za" ? "Zápočet" : "Zkouška") . '" disabled required>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Subject_abbreviation" class="align-text-right col-sm-2 col-form-label">Předmět</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="Subject_abbreviation" class="form-control" name="Subject_abbreviation" value="' . $allExam["zkratka_predmetu"] . '" disabled required>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Room_abbreviation" class="align-text-right col-sm-2 col-form-label">Zkratka místnosti</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="Room_abbreviation" class="form-control" name="Room_abbreviation" value="' . $allExam["zkratka_mistnosti"] . '" disabled required>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Date_time" class="align-text-right col-sm-2 col-form-label">Datum a čas</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="datetime-local" id="Date_time" class="form-control" name="Date_time" value="' . date('Y-m-d\Th:i', strtotime($allExam["datum_cas"])) . '" disabled required>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Description" class="align-text-right col-sm-2 col-form-label">Hodnocení</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="Description" class="form-control" name="Description" value="' . $result["popis"] . '" autofocus>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";