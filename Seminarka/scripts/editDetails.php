<?php

session_start();

require_once 'db.php';

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../index.php");
    exit;
}

if ($_SESSION["role"] !== "pedagog") {
    $_SESSION["error"] = "Na požadovanou stránku má přistup pouze pedagog.";
    header("Location: ".$_SESSION["index"]);
    exit;
}

if (!isset($_POST["type"]) || $_POST["type"] === "" || !in_array($_POST["type"], array("addExam", "exam", "result", "room", "subject")))  {
    $_SESSION["error"] = "Chyba načítání stránky.";
    header("Location: ".$_SESSION["index"]);
    exit;
}

$conn = connect();
require_once 'edit/'.$_POST["type"].'.php';
$conn->close();

header("Location: " . $_SESSION["index"] . "/?page=details&type={$_POST["type"]}&show={$_POST["ID"]}");