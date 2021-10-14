<?php

if(!isset($_SESSION)) {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../index.php");
    exit;
}

function connect()
{
    if($_SERVER['HTTP_HOST'] === "localhost") {
        $host = "localhost";
        $username = "sem";
        $password = "org6RlBEZMTsmb1g";
        $database = "vydap_projekt";
    }
    else {
        $host = "sql4.webzdarma.cz";
        $username = "simara7westr8346";
        $password = "9455I4At)_,5vkDWlL3_";
        $database = "simara7westr8346";
    }

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_errno) {
        session_start();
        $_SESSION["error"] = "Failed to connect to MySQL: " . $conn->connect_error;
        header("Location: ../index.php");
        exit;
    }

    return $conn;
}