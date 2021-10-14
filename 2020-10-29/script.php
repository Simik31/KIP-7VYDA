<?php

function format_youtube_url($url) {
    return "https://www.youtube.com/embed/" . explode("=", $url)[1];
}

function get_working_days($from, $to) {
    $ret = array();
    try {
        $day = new DateTime($from);
        $diff = (new DateTime($to))->diff($day)->format("%a");
        for($add = 0; $add <= $diff; $add++)
            if(in_array(date("w", $day->add(new DateInterval("P1D"))->getTimestamp()), array(1, 2, 3, 4, 5)))
                $ret[] = strval($day->format("Y-m-d"));
    } catch (Exception $e) {
        $ret[] = "Invalid input";
    }
    return $ret;
}

echo '<html>'."\n";
echo '<head>'."\n";
echo '<title>HW 2020-10-29</title>'."\n";
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />'."\n";
echo '<link rel="stylesheet" type="text/css" media="screen" href="./bootstrap/css/bootstrap.css" />'."\n";
echo '</head>'."\n";
echo '<body>'."\n";

echo '<div class="container">'."\n";

echo '<h1>Funkce format_youtube_url($url)</h1>'."\n";

$youtubeTestURL = "https://www.youtube.com/watch?v=Gl_Dnf_aGfQ";

echo 'Input url: ' . $youtubeTestURL . '<br>' . "\n";
echo 'Embed url: ' . format_youtube_url($youtubeTestURL) . '<br>' . "\n";

echo '<br>' . "\n";

$youtubeTestURL = "https://www.youtube.com/watch?v=43kaXfnOGFU";

echo 'Input url: ' . $youtubeTestURL . '<br>' . "\n";
echo 'Embed url: ' . format_youtube_url($youtubeTestURL) . '<br>' . "\n";

echo '<h1>Funkce get_working_days($from, $to)</h1>'."\n";

$from = "2020-10-29";
$to = "2020-11-09";

echo 'Working days ' . $from . ' - ' . $to . ':<br>' . "\n";
foreach(get_working_days($from, $to) as $day) echo $day . '<br>' . "\n";

echo '<br>' . "\n";

$from = "2020-11-01";
$to = "2020-11-30";

echo 'Working days ' . $from . ' - ' . $to . ':<br>' . "\n";
foreach(get_working_days($from, $to) as $day) echo $day . '<br>' . "\n";

echo '<br>' . "\n";

$from = "2020-11-15";
$to = "2020-12-04";

echo 'Working days ' . $from . ' - ' . $to . ':<br>' . "\n";
foreach(get_working_days($from, $to) as $day) echo $day . '<br>' . "\n";

echo '</div>'."\n";
echo '</body>'."\n";
echo '</html> '."\n";