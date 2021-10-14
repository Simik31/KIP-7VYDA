<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../../index.php");
    exit;
}

if (!($subjectSQL = $conn->prepare("SELECT * FROM `predmety` WHERE `zkratka_predmetu` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databáze.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$subjectSQL->bind_param("s", $_GET["edit"]);
$subjectSQL->execute();
$subject = $subjectSQL->get_result()->fetch_assoc();
$subjectSQL->close();

$conn->close();

echo '<h1 class="h3 mb-3 font-weight-normal">Úprava předmětu</h1>' . "\n";
echo '<form class="form" action="scripts/editDetails.php" method="post">' . "\n";
echo '<input type="hidden" name="type" value="' . $_GET["type"] . '">' . "\n";
echo '<input type="hidden" id="ID" class="form-control" name="ID" value="' . $subject["zkratka_predmetu"] . '">' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Subject_abbreviation" class="align-text-right col-sm-2 col-form-label">Zkratka předmětu</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="Subject_abbreviation" class="form-control" name="Subject_abbreviation" value="' . $subject["zkratka_predmetu"] . '" disabled required>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Name" class="align-text-right col-sm-2 col-form-label">Název předmětu</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="Name" class="form-control" name="Name" value="' . $subject["nazev"] . '" required>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Credits" class="align-text-right col-sm-2 col-form-label">Kredity</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="Credits" class="form-control" name="Credits" value="' . $subject["pocet_kreditu"] . '" required>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="HoursOfLectures" class="align-text-right col-sm-2 col-form-label">Hodin přednášek</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="HoursOfLectures" class="form-control" name="HoursOfLectures" value="' . $subject["pocet_hodin_prednasek"] . '" required>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="HoursOfTutorials" class="align-text-right col-sm-2 col-form-label">Hodin cvičení</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<input type="text" id="HoursOfTutorials" class="form-control" name="HoursOfTutorials" value="' . $subject["pocet_hodin_cviceni"] . '" required>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label class="align-text-right col-sm-2 col-form-label">Zakončení</label>' . "\n";
echo '<div class="btn-group padding-left-15 btn-group-toggle" data-toggle="buttons">' . "\n";
echo '<label class="btn btn-secondary ' . ($subject["ukonceni"] === "Za" ? 'active' : '') . '">' . "\n";
echo '<input type="radio" name="FormOfCompletion" value="Zk" id="Exam" ' . ($subject["ukonceni"] === "Za" ? 'checked' : '') . '>Zkouška' . "\n";
echo '</label>' . "\n";
echo '<label class="btn btn-secondary ' . ($subject["ukonceni"] === "Za" ? '' : 'active') . '">' . "\n";
echo '<input type="radio" name="FormOfCompletion" value="Za" id="PreExamCredits" ' . ($subject["ukonceni"] === "Za" ? '' : 'checked') . '>Zápočet' . "\n";
echo '</label>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '<div class="form-group row">' . "\n";
echo '<label for="Annotation" class="align-text-right col-sm-2 col-form-label">Anotace</label>' . "\n";
echo '<div class="col-sm-10">' . "\n";
echo '<textarea id="Annotation" class="form-control" name="Annotation" required>' . "\n";
echo $subject["anotace"] . "\n";
echo '</textarea>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";