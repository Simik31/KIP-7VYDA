<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!isset($_POST["ID"]) || $_POST["ID"] === "") {
    $_SESSION["error"] = "Neplatné ID předmětu.";
    header("Location: ../index.php");
    exit;
}

if (!isset($_POST["Name"]) || $_POST["Name"] === "") {
    $_SESSION["error"] = "Neplatný název.";
    header("Location: ../?page=edit&type=subject&show=" . $_POST["ID"]);
    exit;
}

if (!isset($_POST["Credits"]) || $_POST["Credits"] === "") {
    $_SESSION["error"] = "Neplatný počet kreditů.";
    header("Location: ../?page=edit&type=subject&edit=" . $_POST["ID"]);
    exit;
}

if (!isset($_POST["HoursOfLectures"]) || $_POST["HoursOfLectures"] === "") {
    $_SESSION["error"] = "Neplatný počet hodin přednášek.";
    header("Location: ../?page=edit&type=subject&edit=" . $_POST["ID"]);
    exit;
}

if (!isset($_POST["HoursOfTutorials"]) || $_POST["HoursOfTutorials"] === "") {
    $_SESSION["error"] = "Neplatný počet hodin cvičení.";
    header("Location: ../?page=edit&type=subject&edit=" . $_POST["ID"]);
    exit;
}

if (!($subjectSQL = $conn->prepare("UPDATE `predmety` SET `nazev` = ?, `pocet_kreditu`= ?, `pocet_hodin_prednasek` = ?, `pocet_hodin_cviceni` = ?, `ukonceni` = ?, `anotace` = ? WHERE `zkratka_predmetu` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: ../?page=edit&type=subject&edit=" . $_POST["ID"]);
    exit;
}

$subjectSQL->bind_param("siiisss", $_POST["Name"], $_POST["Credits"], $_POST["HoursOfLectures"], $_POST["HoursOfTutorials"], $_POST["FormOfCompletion"], $_POST["Annotation"], $_POST["ID"]);
$updateSubject = $subjectSQL->execute();
$subjectSQL->close();

if ($updateSubject) {
    $_SESSION["success"] = "Změny byly uloženy.";
} else {
    $_SESSION["error"] = "Změny nebylo možné uložit.";
}