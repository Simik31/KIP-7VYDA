<?php
session_start();
$_SESSION["error"] = "Pro přístup do systému se přihlašte.";
header("Location: ../../index.php");