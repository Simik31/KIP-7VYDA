<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../index.php");
    exit;
}

$studentID = $_SESSION["ID"];

if (!($allMySubjectsSQL = $conn->prepare("SELECT * FROM studenti_predmety WHERE kod_studenta = ?")) ||
    !($allResultsSQL = $conn->prepare("SELECT * FROM `vysledky`")) ||
    !($allTeachersSQL = $conn->prepare("SELECT * FROM `pedagogove`")) ||
    !($allMyExamsSQL = $conn->prepare("SELECT * FROM `zapsane_terminy`")) ||
    !($subjectsNamesSQL = $conn->prepare("SELECT * FROM `predmety`")) ||
    !($allExamsSQL = $conn->prepare("SELECT * FROM `vypsane_terminy`"))) {
    $_SESSION["error"] = "Chyba načítání databááze.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$mySubjectsList = array();
$resultsList = array();
$teachersList = array();
$teachersNames = array();
$myExamsList = array();
$myResultIDs = array();
$roomOccupancyList = array();
$futureExams = array();
$availableExams = array();
$pastExams = array();
$subjectNames = array();
$subName = array();

$allMySubjectsSQL->bind_param("i", $studentID);
$allMySubjectsSQL->execute();
$allMySubjects = $allMySubjectsSQL->get_result();
$allMySubjectsSQL->close();
foreach ($allMySubjects as $subject) {
    $mySubjectsList[] = $subject["zkratka_predmetu"];
}

$allResultsSQL->execute();
$allResults = $allResultsSQL->get_result();
$allResultsSQL->close();
foreach ($allResults as $result) {
    $resultsList[$result["id_vysledku"]] = $result["popis"];
}

$allTeachersSQL->execute();
$allTeachers = $allTeachersSQL->get_result();
$allTeachersSQL->close();
foreach ($allTeachers as $teacher) {
    $teachersList[$teacher["kod_pedagoga"]] = $teacher;
}

$allMyExamsSQL->execute();
$allMyExams = $allMyExamsSQL->get_result();
$allMyExamsSQL->close();
foreach ($allMyExams as $exam) {
    if (isset($roomOccupancyList[$exam["id_terminu"]])) {
        $roomOccupancyList[$exam["id_terminu"]]++;
    } else {
        $roomOccupancyList[$exam["id_terminu"]] = 1;
    }
    if ($exam["kod_studenta"] === $studentID) {
        $myExamsList[] = $exam["id_terminu"];
        $myResultIDs[$exam["id_terminu"]] = $exam["id_vysledku"];
    }
}

$subjectsNamesSQL->execute();
$subjectsNames = $subjectsNamesSQL->get_result();
$subjectsNamesSQL->close();
foreach ($subjectsNames as $subjectsName) {
    $subjectNames[$subjectsName["zkratka_predmetu"]] = $subjectsName["nazev"];
}

$allExamsSQL->execute();
$allExams = $allExamsSQL->get_result();
$allExamsSQL->close();
foreach ($allExams as $exam) {
    if (in_array($exam["zkratka_predmetu"], $mySubjectsList, true)) {
        if (in_array($exam["id_terminu"], $myExamsList, true)) {
            if (strtotime($exam["datum_cas"]) > time()) {
                $futureExams[] = $exam;
            } else {
                $pastExams[] = $exam;
            }
        } else if (strtotime($exam["datum_cas"]) > time()) {
            $availableExams[] = $exam;
        }
        $t = $teachersList[$exam["kod_pedagoga"]];
        $teachersNames[$exam["id_terminu"]] = $t["tituly_pred_jmenem"] . ' ' . $t["jmeno"] . ' ' . $t["prijmeni"] . ', ' . $t["tituly_za_jmenem"];
        if (!isset($roomOccupancyList[$exam["id_terminu"]])) {
            $roomOccupancyList[$exam["id_terminu"]] = 0;
        }
        $subName[$exam["id_terminu"]] = $subjectNames[$exam["zkratka_predmetu"]];
    }
}

$conn->close();

echo '<h1 class="h3 mb-3 font-weight-normal">'."\n";
echo '<button class="btn float-left btn-primary invisible col-sm-2"></button>'."\n";
echo $_SESSION["Name"]."\n";
echo '<a href="scripts/Logout.php">' ."\n";
echo '<button class="btn float-right btn-primary col-sm-2">Odhlásit se</button>'."\n";
echo '</a>'."\n";
echo '</h1>'."\n";
echo '<h1 class="h3 mb-3 font-weight-normal">Zapsané termíny</h1>' . "\n";
echo '<table class="table table-hover table-bordered">' . "\n";
echo '<thead>' . "\n";
echo '<tr>' . "\n";
echo '<th scope="col">Datum a čas</th>' . "\n";
echo '<th scope="col">Předmět</th>' . "\n";
echo '<th scope="col">Místnost</th>' . "\n";
echo '<th scope="col">Obsazení</th>' . "\n";
echo '<th scope="col">Zkoušející</th>' . "\n";
echo '<th scope="col">Poznámka</th>' . "\n";
echo '<th scope="col">Akce</th>' . "\n";
echo '</tr>' . "\n";
echo '</thead>' . "\n";
echo '<tbody>' . "\n";

foreach ($futureExams as $exam) {
    echo '<tr>' . "\n";
    echo '<th>' . date('d.m.Y H:i', strtotime($exam["datum_cas"])) . '</th>' . "\n";
    echo '<th><a data-toggle="tooltip" data-placement="left" title="'.$subName[$exam["id_terminu"]].'" href="?page=details&type=subject&show=' . $exam["zkratka_predmetu"] . '">' . $exam["zkratka_predmetu"] . '</a></th>' . "\n";
    echo '<th><a href="?page=details&type=room&show=' . $exam["zkratka_mistnosti"] . '">' . $exam["zkratka_mistnosti"] . '</a></th>' . "\n";
    echo '<th><a href="?page=details&type=students&show=' . $exam["id_terminu"] . '">' . $roomOccupancyList[$exam["id_terminu"]] . '</a>/' . $exam["max_pocet_prihlasenych"] . '</th>' . "\n";
    echo '<th><a href="?page=details&type=teacher&show=' . $exam["kod_pedagoga"] . '">' . $teachersNames[$exam["id_terminu"]] . '</a></th>' . "\n";
    echo '<th>' . $exam["poznamka"] . '</th>' . "\n";

    if (strtotime($exam["datum_cas"]) > strtotime("+ 24 hours")) {
        echo '<th><a href="scripts/cancel.php?examId=' . $exam["id_terminu"] . '"><button class="btn btn-primary btn-sm">Odepsat</button></a></th>' . "\n";
    } else {
        echo '<th><span class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" data-html="true" title="Termín nelze odepsat<br>Termín je za méně než den">Odepsat</span></th>' . "\n";
    }

    echo '</tr>' . "\n";
}

echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '<h1 class="h3 mb-3 font-weight-normal">Vypsané termíny</h1>' . "\n";
echo '<table class="table table-hover table-bordered">' . "\n";
echo '<thead>' . "\n";
echo '<tr>' . "\n";
echo '<th scope="col">Datum a čas</th>' . "\n";
echo '<th scope="col">Předmět</th>' . "\n";
echo '<th scope="col">Místnost</th>' . "\n";
echo '<th scope="col">Obsazení</th>' . "\n";
echo '<th scope="col">Zkoušející</th>' . "\n";
echo '<th scope="col">Poznámka</th>' . "\n";
echo '<th scope="col">Akce</th>' . "\n";
echo '</tr>' . "\n";
echo '</thead>' . "\n";
echo '<tbody>' . "\n";

foreach ($availableExams as $exam) {
    echo '<tr>' . "\n";
    echo '<th>' . date('d.m.Y H:i', strtotime($exam["datum_cas"])) . '</th>' . "\n";
    echo '<th><a data-toggle="tooltip" data-placement="left" title="'.$subName[$exam["id_terminu"]].'" href="?page=details&type=subject&show=' . $exam["zkratka_predmetu"] . '">' . $exam["zkratka_predmetu"] . '</a></th>' . "\n";
    echo '<th><a href="?page=details&type=room&show=' . $exam["zkratka_mistnosti"] . '">' . $exam["zkratka_mistnosti"] . '</a></th>' . "\n";
    echo '<th>' . $roomOccupancyList[$exam["id_terminu"]] . '/' . $exam["max_pocet_prihlasenych"] . '</th>' . "\n";
    echo '<th><a href="?page=details&type=teacher&show=' . $exam["kod_pedagoga"] . '">' . $teachersNames[$exam["id_terminu"]] . '</a></th>' . "\n";
    echo '<th>' . $exam["poznamka"] . '</th>' . "\n";

    if ($roomOccupancyList[$exam["id_terminu"]] < $exam["max_pocet_prihlasenych"]) {
        if (strtotime($exam["datum_cas"]) > strtotime("+ 24 hours")) {
            echo '<th class="p-2">' . "\n";
            echo '<a href="scripts/register.php?examId=' . $exam["id_terminu"] . '"><button class="btn btn-primary btn-sm">Zapsat</button></a>' . "\n";
            echo '</th>' . "\n";
        } else {
            echo '<th class="p-2" data-toggle="tooltip" data-html="true" title="Termín nelze zapsat<br>Termín je za méně než den">' . "\n";
            echo '<button class="btn btn-secondary btn-sm" disabled>Zapsat</button>' . "\n";
            echo '</th>' . "\n";
        }
    } else {
        echo '<th class="p-2" data-toggle="tooltip" data-html="true" title="Termín nelze zapsat<br>Termínu je plný"><button class="btn btn-secondary btn-sm" disabled>Zapsat</button></th>' . "\n";
        echo '<button class="btn btn-secondary btn-sm" disabled>Zapsat</button>' . "\n";
        echo '</th>' . "\n";
    }

    echo '</tr>' . "\n";
}

echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '<h1 class="h3 mb-3 font-weight-normal">Proběhlé termíny</h1>' . "\n";
echo '<table class="table table-hover table-bordered">' . "\n";
echo '<thead>' . "\n";
echo '<tr>' . "\n";
echo '<th scope="col"">Datum a čas</th>' . "\n";
echo '<th scope="col">Předmět</th>' . "\n";
echo '<th scope="col">Místnost</th>' . "\n";
echo '<th scope="col">Obsazení</th>' . "\n";
echo '<th scope="col">Zkoušející</th>' . "\n";
echo '<th scope="col">Poznámka</th>' . "\n";
echo '<th scope="col">Hodnocení</th>' . "\n";
echo '</tr>' . "\n";
echo '</thead>' . "\n";
echo '<tbody>' . "\n";

foreach ($pastExams as $exam) {
    echo '<tr>' . "\n";
    echo '<th scope="row">' . date('d.m.Y H:i', strtotime($exam["datum_cas"])) . '</th>' . "\n";
    echo '<th><a data-toggle="tooltip" data-placement="left" title="'.$subName[$exam["id_terminu"]].'" href="?page=details&type=subject&show=' . $exam["zkratka_predmetu"] . '">' . $exam["zkratka_predmetu"] . '</a></th>' . "\n";
    echo '<th><a href="?page=details&type=room&show=' . $exam["zkratka_mistnosti"] . '">' . $exam["zkratka_mistnosti"] . '</a></th>' . "\n";
    echo '<th><a href="?page=details&type=students&show=' . $exam["id_terminu"] . '">' . $roomOccupancyList[$exam["id_terminu"]] . '</a>/' . $exam["max_pocet_prihlasenych"] . '</th>' . "\n";
    echo '<th><a href="?page=details&type=teacher&show=' . $exam["kod_pedagoga"] . '">' . $teachersNames[$exam["id_terminu"]] . '</a></th>' . "\n";
    echo '<th>' . $exam["poznamka"] . '</th>' . "\n";
    echo '<th>';

    if (isset($resultsList[$myResultIDs[$exam["id_terminu"]]])) {
        echo '<a href="?page=details&type=result&show=' . $myResultIDs[$exam["id_terminu"]] . '">' . $resultsList[$myResultIDs[$exam["id_terminu"]]] . '</a>';
    }

    echo '</th>' . "\n";
    echo '</tr>' . "\n";
}

echo '</tbody>' . "\n";
echo '</table>' . "\n";