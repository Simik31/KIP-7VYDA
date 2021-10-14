<?php

echo '<html lang="en">'."\n";
echo '<head>'."\n";
echo '<title>Registrační formulář</title>'."\n";
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />'."\n";
echo '<link rel="stylesheet" type="text/css" media="screen" href="./bootstrap/css/bootstrap.css" />'."\n";
echo '<link rel="stylesheet" type="text/css" media="screen" href="./styl.css" />'."\n";
echo '</head>'."\n";
echo '<body>'."\n";
echo '<div class="container">'."\n";
echo '<table class="table table-bordered">'."\n";
echo '<thead>'."\n";
echo '<tr>'."\n";
echo '<th>File</th>'."\n";
echo '<th>Size</th>'."\n";
echo '</thead>'."\n";
echo '<tbody>'."\n";

$dir = scandir("files");

foreach($dir as $file) {
    if (!in_array($file, array(".", "..")))
    {
        echo '<tr>'."\n";
        echo '<th><a href="files/' . $file . '" target="_blank">' . $file . '</a></th>';
        echo '<th>' . intdiv(filesize('files/'.$file), 1024) . ' kB</th>'."\n";
        echo '</tr>'."\n";
    }
}

echo '</tbody>'."\n";
echo '</table>'."\n";
echo '</div>'."\n";
echo '</body>'."\n";
echo '</html> '."\n";