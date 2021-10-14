<?php

session_start();

require_once 'db.php';

if(!isset($_POST["name"]) || $_POST["name"] === "") {
    $_SESSION["error"] = "Zadejte jméno a příjmení.";
    header("Location: ../index.php");
    exit;
}

if(!isset($_POST["password"]) || $_POST["password"] === "") {
    $_SESSION["error"] = "Zadejte heslo.";
    header("Location: ../index.php");
    exit;
}

if (!preg_match("/\S{1,30}+\s+\S{1,30}/", $_POST["name"]) || !preg_match("/\S{1,20}/", $_POST["password"])) {
    $_SESSION["error"] = "Zadejte jméno a příjmení ve správném formátu.";
    header("Location: ../index.php");
    exit;
}

[$name, $surname] = explode(" ", $_POST["name"]);
$conn = connect();

if (!($teachers = $conn->prepare("SELECT * FROM `pedagogove` WHERE `jmeno` = ? AND `prijmeni` = ?")) ||
    !($students = $conn->prepare("SELECT * FROM `studenti` WHERE `jmeno` = ? AND `prijmeni` = ?"))){
    $_SESSION["error"] = "Chyba při načítání databáze.";
    header("Location: ../index.php");
    exit;
}

$teachers->bind_param("ss", $name, $surname);
$teachers->execute();
$teacher = $teachers->get_result();
$teachers->close();
if ($teacher->num_rows === 1) {
    $teacher = $teacher->fetch_assoc();

    if (!password_verify($_POST["password"], $teacher["heslo"])) {
        $_SESSION["error"] = "Chybné uživatelské jméno nebo heslo.";
        header("Location: ../index.php");
        exit;
    }

    $_SESSION["error"] = "";
    $_SESSION["success"] = "Vítejte!";
    $_SESSION["logged"] = "In";
    $_SESSION["ID"] = $teacher["kod_pedagoga"];
    $_SESSION["role"] = "pedagog";
    $_SESSION["Name"] = $teacher["tituly_pred_jmenem"] . " " . $teacher["jmeno"] . " " . $teacher["prijmeni"] . ", " . $teacher["tituly_za_jmenem"];
    $_SESSION["index"] = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
    if($_SERVER['HTTP_HOST'] === 'localhost') {
        $_SESSION["index"] .= "/Seminarka/";
    }
    header("Location: ".$_SESSION["index"]);
    exit;
}

$students->bind_param("ss", $name, $surname);
$students->execute();
$student = $students->get_result();
$students->close();
if ($student->num_rows === 1) {
    $student = $student->fetch_assoc();
    if (!password_verify($_POST["password"], $student["heslo"])) {
        $_SESSION["error"] = "Chybné uživatelské jméno nebo heslo.";
        header("Location: ../index.php");
        exit;
    }

    $_SESSION["error"] = "";
    $_SESSION["success"] = "Vítejte!";
    $_SESSION["logged"] = "In";
    $_SESSION["ID"] = $student["kod_studenta"];
    $_SESSION["role"] = "student";
    $_SESSION["Name"] = $student["jmeno"] . " " . $student["prijmeni"];
    $_SESSION["index"] = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
    if($_SERVER['HTTP_HOST'] === 'localhost') {
        $_SESSION["index"] .= "/Seminarka/";
    }
    header("Location: " . $_SESSION["index"]);
    exit;
}

$conn->close();

$_SESSION["error"] = "Uživatel nebyl nalezen.";
header("Location: ../index.php");