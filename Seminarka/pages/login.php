<?php

if(!isset($_SESSION)) {
    session_start();
    $_SESSION["error"] = "Pro přístup do systému se přihlašte.";
    header("Location: ../index.php");
    exit;
}

echo '<form class="form max-w-330" action="scripts/Login.php" method="post">'."\n";
echo '<h1 class="h3 mb-3 font-weight-normal">Přihlášení</h1>'."\n";
echo '<input type="hidden" name="action" value="login">'."\n";
echo '<label for="name" class="sr-only">Jméno a příjmení</label>'."\n";
echo '<input type="text" id="name" class="form-control" name="name" placeholder="Jméno a příjmení" autocomplete="on" required autofocus>'."\n";
echo '<label for="inputPassword" class="sr-only">Heslo</label>'."\n";
echo '<input type="password" id="inputPassword" class="form-control" name="password" placeholder="Heslo" autocomplete="off" required>'."\n";
echo '<button class="btn btn-lg btn-primary btn-block" type="submit">Přihlásit se</button>'."\n";
echo '</form>'."\n";