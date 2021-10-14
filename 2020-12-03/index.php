<?php


echo '<html>'."\n";
echo '<head>'."\n";
echo '<title>První</title>'."\n";
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />'."\n";
echo '<link rel="stylesheet" type="text/css" media="screen" href="./bootstrap/css/bootstrap.css" />'."\n";
echo '</head>'."\n";
echo '<body>'."\n";

echo '<div class="container">'."\n";

echo '<h1>Práce s XML</h1>'."\n";

//Načtení XML souboru
$xml = simplexml_load_file('employees.xml');

echo '<h2>Zobrazení zaměstnanců</h2>';

$list = $xml->record;

for($i = 0; $i < count($list); $i++) {
    echo '<p><strong>ID: </strong>' . $list[$i]->attributes()->employee_no . '<br>' . "\n";
    echo 'Name: ' . $list[$i]->name . '<br>' . "\n";
    echo 'Age: ' . $list[$i]->name->attributes()->age . '<br>' . "\n";
    echo 'Position: ' . $list[$i]->position . "\n";
    echo '</p>' . "\n";
}

echo '</div>'."\n";
echo '</body>'."\n"; 
echo '</html>'."\n"; 

?>
