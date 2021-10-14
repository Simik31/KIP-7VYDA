<?php

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] !== "In") {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../index.php");
    exit;
}

if (!($examsSQL = $conn->prepare("SELECT id_terminu FROM `zapsane_terminy`")) ||
    !($subjectsNamesSQL = $conn->prepare("SELECT * FROM `predmety`")) ||
    !($allExamsSQL = $conn->prepare("SELECT * FROM `vypsane_terminy` WHERE `kod_pedagoga` = ?"))) {
    $_SESSION["error"] = "Chyba načítání databááze.";
    header("Location: " . $_SESSION["index"]);
    exit;
}

$futureExams = array();
$pastExams = array();
$roomOccupancy = array();
$subjectNames = array();
$subName = array();

$examsSQL->execute();
$exams = $examsSQL->get_result();
$examsSQL->close();
foreach ($exams as $exam) {
    if (isset($roomOccupancy[$exam["id_terminu"]])) {
        $roomOccupancy[$exam["id_terminu"]]++;
    } else {
        $roomOccupancy[$exam["id_terminu"]] = 1;
    }
}

$subjectsNamesSQL->execute();
$subjectsNames = $subjectsNamesSQL->get_result();
$subjectsNamesSQL->close();
foreach ($subjectsNames as $subjectsName) {
    $subjectNames[$subjectsName["zkratka_predmetu"]] = $subjectsName["nazev"];
}

$allExamsSQL->bind_param("i", $_SESSION["ID"]);
$allExamsSQL->execute();
$exams = $allExamsSQL->get_result();
$allExamsSQL->close();

foreach ($exams as $exam) {
    if (strtotime($exam["datum_cas"]) > time()) {
        $futureExams[] = $exam;
    } else {
        $pastExams[] = $exam;
    }
    if (!isset($roomOccupancy[$exam["id_terminu"]])) {
        $roomOccupancy[$exam["id_terminu"]] = 0;
    }
    $subName[$exam["id_terminu"]] = $subjectNames[$exam["zkratka_predmetu"]];
}

$conn->close();

echo '<h1 class="h3 mb-3 font-weight-normal">'."\n";
echo '<button class="btn float-left btn-primary invisible col-sm-2"></button>'."\n";
echo $_SESSION["Name"]."\n";
echo '<a href="scripts/Logout.php">' ."\n";
echo '<button class="btn float-right btn-primary col-sm-2">Odhlásit se</button>'."\n";
echo '</a>'."\n";
echo '</h1>'."\n";
echo '<h1 class="h3 mb-3 font-weight-normal">Vypsané termíny</h1>' . "\n";
echo '<table class="table table-hover table-bordered">' . "\n";
echo '<thead>' . "\n";
echo '<tr>' . "\n";
echo '<th scope="col" class="date_time">Datum a čas</th>' . "\n";
echo '<th scope="col">Předmět</th>' . "\n";
echo '<th scope="col">Místnost</th>' . "\n";
echo '<th scope="col">Obsazení</th>' . "\n";
echo '<th scope="col">Poznámka</th>' . "\n";
echo '<th scope="col" class="edit_exam">Editace</th>' . "\n";
echo '</tr>' . "\n";
echo '</thead>' . "\n";
echo '<tbody>' . "\n";

foreach ($futureExams as $exam) {
    echo '<tr>' . "\n";
    echo '<th scope="row">' . date('d.m.Y H:i', strtotime($exam["datum_cas"])) . '</th>' . "\n";
    echo '<th><a data-toggle="tooltip" data-placement="left" title="'.$subName[$exam["id_terminu"]].'" href="?page=details&type=subject&show=' . $exam["zkratka_predmetu"] . '">' . $exam["zkratka_predmetu"] . '</a></th>' . "\n";
    echo '<th><a href="?page=details&type=room&show=' . $exam["zkratka_mistnosti"] . '">' . $exam["zkratka_mistnosti"] . '</a></th>' . "\n";

    if ($roomOccupancy[$exam["id_terminu"]] > 0) {
        echo '<th><a href="?page=details&type=students&show=' . $exam["id_terminu"] . '">' . $roomOccupancy[$exam["id_terminu"]] . '</a>/' . $exam["max_pocet_prihlasenych"] . '</th>' . "\n";
    } else {
        echo '<th>' . $roomOccupancy[$exam["id_terminu"]] . '/' . $exam["max_pocet_prihlasenych"] . '</th>' . "\n";
    }

    echo '<th>' . $exam["poznamka"] . '</th>' . "\n";
    echo '<th><a href="?page=edit&type=exam&edit=' . $exam["id_terminu"] . '">Upravit termín</a></th>' . "\n";
    echo '</tr>' . "\n";
}

echo '</tbody>' . "\n";
echo '</table>' . "\n";
echo '<a href="?page=edit&type=addExam">' . "\n";
echo '<button class="btn float-right btn-primary col-sm-2" type="submit">Přidat termín</button>' . "\n";
echo '</a>' . "\n";
echo '<br><br>' . "\n";
echo '<h1 class="h3 mb-3 font-weight-normal">Proběhlé termíny</h1>' . "\n";
echo '<table class="table table-hover table-bordered">' . "\n";
echo '<thead>' . "\n";
echo '<tr>' . "\n";
echo '<th scope="col" class="date_time">Datum a čas</th>' . "\n";
echo '<th scope="col">Předmět</th>' . "\n";
echo '<th scope="col">Místnost</th>' . "\n";
echo '<th scope="col">Obsazení</th>' . "\n";
echo '<th scope="col">Poznámka</th>' . "\n";
echo '<th scope="col" class="edit_results">Hodnocení</th>' . "\n";
echo '</tr>' . "\n";
echo '</thead>' . "\n";
echo '<tbody>' . "\n";

foreach ($pastExams as $exam) {
    echo '<tr>' . "\n";
    echo '<th scope="row">' . date('d.m.Y H:i', strtotime($exam["datum_cas"])) . '</th>' . "\n";
    echo '<th><a data-toggle="tooltip" data-placement="left" title="'.$subName[$exam["id_terminu"]].'" href="?page=details&type=subject&show=' . $exam["zkratka_predmetu"] . '">' . $exam["zkratka_predmetu"] . '</a></th>' . "\n";
    echo '<th><a href="?page=details&type=room&show=' . $exam["zkratka_mistnosti"] . '">' . $exam["zkratka_mistnosti"] . '</a></th>' . "\n";

    if ($roomOccupancy[$exam["id_terminu"]] > 0) {
        echo '<th><a href="?page=details&type=students&show=' . $exam["id_terminu"] . '">' . $roomOccupancy[$exam["id_terminu"]] . '</a>/' . $exam["max_pocet_prihlasenych"] . '</th>' . "\n";
    } else {
        echo '<th>' . $roomOccupancy[$exam["id_terminu"]] . '/' . $exam["max_pocet_prihlasenych"] . '</th>' . "\n";
    }

    echo '<th>' . $exam["poznamka"] . '</th>' . "\n";
    echo '<th>' . "\n";

    if (strtotime($exam["datum_cas"]) < time()) {
        echo '<a href="?page=details&type=results&examId=' . $exam["id_terminu"] . '">Hodnotit studenty</a>' . "\n";
    }

    echo '</th>' . "\n";
    echo '</tr>' . "\n";
}

echo '</tbody>' . "\n";
echo '</table>' . "\n";