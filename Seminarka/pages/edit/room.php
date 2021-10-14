<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!($roomsSQL = $conn->prepare("SELECT * FROM `mistnosti` WHERE `zkratka_mistnosti` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$roomsSQL->bind_param("s", $_GET["edit"]);
$roomsSQL->execute();
$room = $roomsSQL->get_result()->fetch_assoc();
$roomsSQL->close();

$conn->close();

echo '<h1 class="h3 mb-3 font-weight-normal">Úprava místnosti</h1>' . "\n";
echo '<form class="form" action="scripts/editDetails.php" method="post">' . "\n";
echo '<input type="hidden" name="type" value="' . $_GET["type"] . '">' . "\n";
echo '<input type="hidden" id="ID" class="form-control" name="ID" value="' . $room["zkratka_mistnosti"] . '">' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Room_abbreviation" class="align-text-right col-sm-2 col-form-label">Zkratka místnosti</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="Room_abbreviation" class="form-control" name="Room_abbreviation" value="' . $room["zkratka_mistnosti"] . '" disabled required>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Description" class="align-text-right col-sm-2 col-form-label">Popis</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="Description" class="form-control" name="Description" value="' . $room["popis"] . '" required>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Capacity" class="align-text-right col-sm-2 col-form-label">Kapacita</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="Capacity" class="form-control" name="Capacity" value="' . $room["kapacita"] . '" required>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";