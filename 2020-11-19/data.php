<?php   

require "./configure.php";
require "./connect.php";

?>

<html>
<head>
<title>Produkty a objednávky</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="screen" href="./bootstrap/css/bootstrap.css" />
</head>
<body>
<div class="container">
<?php

echo '<div class="container">'."\n";

echo '<h1>Produkty a objednávky</h1>'."\n";

echo '<h2>Produkty</h2>'."\n";

$result_products=mysqli_query($conn,'select * from '._TABLE_PRODUCTS.' order by id');
if(@mysqli_num_rows($result_products) > 0)
{
echo '<table class="table table-bordered">'."\n";
echo '<tr>'."\n";
    echo '<th>ID</th>'."\n";
    echo '<th>Název</th>'."\n";
    echo '<th>Cena bez DPH</th>'."\n";
    echo '<th>Cena s DPH</th>'."\n";
echo '</tr>'."\n";
while ($entry=mysqli_fetch_array($result_products))
{
  echo '<tr>'."\n";
    echo '<td>'.$entry['id'].'</td>'."\n";
    echo '<td>'.$entry['name'].'</td>'."\n";
    echo '<td>'.$entry['price_no_vat'].' Kč</td>'."\n";
    echo '<td>'.$entry['price_vat'].' Kč</td>'."\n";
  echo '</tr>'."\n";  
}
echo '</table>'."\n";
}
else
{
  echo '<p><b>Nebyly nalezeny žádné záznamy</b></p>'."\n"; 
}

echo '<h2>Objednávky</h2>'."\n";
$result_orders=mysqli_query($conn,'select o.id as oid, o.product_id as oproduct_id, o.quantity as 
oquantity, p.name as pname, p.price_vat as pprice_vat, p.price_no_vat as pprice_no_vat  
from '._TABLE_ORDERS.' o, '._TABLE_PRODUCTS.' p where o.product_id = p.id order by o.id');
echo '<table class="table table-bordered">'."\n";
echo '<tr>'."\n";
    echo '<th>ID</th>'."\n";
    echo '<th>Produkt</th>'."\n";
    echo '<th>Množství</th>'."\n";
    echo '<th>Cena bez DPH/kus</th>'."\n";
    echo '<th>Celková cena bez DPH</th>'."\n";
    echo '<th>Celková cena s DPH</th>'."\n";
echo '</tr>'."\n";
while ($entry_order=mysqli_fetch_array($result_orders))
{
  echo '<tr>'."\n";
    echo '<td>'.$entry_order['oid'].'</td>'."\n";
    echo '<td>'.$entry_order['pname'].'</td>'."\n";
    echo '<td>'.$entry_order['oquantity'].'</td>'."\n";
    echo '<td>'.$entry_order['pprice_no_vat'].' Kč</td>'."\n";
    echo '<td>'.($entry_order['oquantity'] * $entry_order['pprice_no_vat']).' Kč</td>'."\n";
    echo '<td>'.($entry_order['oquantity'] * $entry_order['pprice_vat']).' Kč</td>'."\n";
  echo '</tr>'."\n";  
}
echo '</table>'."\n";


mysqli_close($conn); 


?>

</div>
</body>
</html>
