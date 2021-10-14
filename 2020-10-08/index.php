<?php


echo '<html>'."\n";
echo '<head>'."\n";
echo '<title>První</title>'."\n";
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />'."\n";
echo '</head>'."\n";
echo '<body>'."\n";

echo '<div class="container">'."\n";

echo '<h1>První</h1>'."\n";

echo '<h2>Nadpis 2</h2>'."\n";

$text = 'první text';

echo "Hello world";

echo '<p>'.$text.'</p>'."\n";

/*
komentář1
komentář2

*/
//Logická proměnná, hodnoty true, false
$bool1 = true;

echo $bool1.'<br>';

//Číselná proměnná
$num1 = 2;
//Proměnná typu float
$num2 = 5.2;

echo $num2.'<br>';

//Zakladni operace +, -, / - dělení, * - násobení
$result = $num1 + $num2;
echo $result.'<br>';

//Promměné typu řetězec, textové proměnné
$string1 = 'text';
$string2 = 'text12439';

echo $string1.' '.$string2.'<br>';

echo 'Počet znaků proměnné string2: '.strlen($string2).'<br>';

//Vytvoření nového pole
//První varianta vytváření polí
$numbers = array();
//První prvek s indexem 0 a hodnotou 10
$numbers[] = 10;
$numbers[] = 20;
$numbers[] = 30;
$numbers[] = 40;

echo 'První prvek pole má hodnotu: '.$numbers[3].'<br>';

//Pole typu float
$floats = array();
$floats[0] = 10.2;
$floats[4] = 15.7;
$floats[8] = 16.8;
$floats[12] = 20.9; 

echo $floats[12].'<br>';

//Asociativni pole
$names = array();
$names["prvni"] = "Petr";
$names["druhe"] = "Jana";
$names["treti"] = "Martin";
$names["ctvrte"] = "Pavla";

echo 'Prvek s klíčem prvni: '.$names['treti'].'<br>';

//Druhá varianta vytváření polí
$numbers2 = array(10, 20, 30, 40);
$numbers2[4] = 50;

echo $numbers2[4].'<br>';

$floats2 = array(0 => 10.7, 4 => 10.3, 8 => 12.8, 12 => 16.8);
$floats2[] = 15.2;

echo $floats2[13].'<br>';

$names2 = array("prvni" => "Petr", "druhe" => "Jana", "treti" => "Martin", "ctvrte" => "Pavla");







 

echo '</div>'."\n";
echo '</body>'."\n"; 
echo '</html>'."\n"; 

?>
