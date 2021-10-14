<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!($subjectsSQL = $conn->prepare("SELECT * FROM `pedagogove_predmety` WHERE `kod_pedagoga` = ?")) ||
    !($roomsSQL = $conn->prepare("SELECT * FROM `mistnosti`"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$subjectsSQL->bind_param("s", $_SESSION["ID"]);
$subjectsSQL->execute();
$subjects = $subjectsSQL->get_result();
$subjectsSQL->close();

$roomsSQL->execute();
$rooms = $roomsSQL->get_result();
$roomsSQL->close();

$conn->close();

echo '<h1 class="h3 mb-3 font-weight-normal">Nový termín</h1>' . "\n";
echo '<form class="form" action="scripts/editDetails.php" method="post">' . "\n";
echo '<input type="hidden" name="type" value="' . $_GET["type"] . '">' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Subject_abbreviation" class="align-text-right col-sm-2 col-form-label">Zkratka předmětu</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<select name="Subject_abbreviation" id="Subject_abbreviation" class="form-control selectpicker">' . "\n";

foreach ($subjects as $subject) {
    echo '<option>' . $subject["zkratka_predmetu"] . '</option>' . "\n";
}

echo '</select>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Room_abbreviation" class="align-text-right col-sm-2 col-form-label">Zkratka místnosti</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<select name="Room_abbreviation" id="Room_abbreviation" class="form-control selectpicker">' . "\n";

foreach ($rooms as $room) {
    echo '<option>' . $room["zkratka_mistnosti"] . '</option>' . "\n";
}

echo '</select>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Date_time" class="align-text-right col-sm-2 col-form-label">Datum a čas</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="datetime-local" id="Date_time" class="form-control" name="Date_time" min="'.date('Y-m-d\Th:i', strtotime("+ 1 week")).'" max="'.date('Y-m-d\Th:i', strtotime("+ 6 months")).'" >' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Note" class="align-text-right col-sm-2 col-form-label">Poznámka</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="Note" class="form-control" name="Note" value="">' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";