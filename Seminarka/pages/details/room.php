<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!($roomSQL = $conn->prepare("SELECT * FROM `mistnosti` WHERE `zkratka_mistnosti` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ".$_SESSION["index"]);
    exit;
}

$roomSQL->bind_param("s", $_GET["show"]);
$roomSQL->execute();
$room = $roomSQL->get_result()->fetch_assoc();
$roomSQL->close();

$conn->close();

echo '<h1 class="h3 mb-3 font-weight-normal">Detail místnosti</h1>' . "\n";
echo '<table class="table table-bordered">' . "\n";
echo '<tbody>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Místnost</th>' . "\n";
echo '<th class="align-text-left">' . $room["zkratka_mistnosti"] . '</th>' . "\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Popis</th>' . "\n";
echo '<th class="align-text-left">' . $room["popis"] . '</th>' . "\n";
echo '</tr>' . "\n";
echo '<tr>' . "\n";
echo '<th class="align-text-right col" scope="row">Kapacita</th>' . "\n";
echo '<th class="align-text-left">' . $room["kapacita"] . '</th>' . "\n";
echo '</tr>' . "\n";
echo '</tbody>' . "\n";
echo '</table>' . "\n";


if($_SESSION["role"] === "pedagog") {
    echo '<a href="?page=edit&type=' . $_GET["type"] . '&edit=' . $_GET["show"] . '">' . "\n";
    echo '<button class="btn btn-primary col-sm-2">Upravit místnost</button>' . "\n";
    echo '</a>' . "\n";
}