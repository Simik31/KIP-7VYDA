<?php
session_start();
$_SESSION["error"] = "";
$_SESSION["success"] = "";
$_SESSION["logged"] = "";
$_SESSION["ID"] = "";
$_SESSION["role"] = "";
$_SESSION["Name"] = "";
$_SESSION["index"] = "";
session_destroy();
header("Location: ../index.php");