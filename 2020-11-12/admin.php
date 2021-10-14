<?php   

require "./configure.php";
require "./connect.php";
require "./session.php";

?>

<html>
<head>
<title>Správa uživatelů</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="screen" href="./bootstrap/css/bootstrap.css" />
</head>
<body>
<div class="container">
<?php
$user_login = $_SESSION['user_login'];
$user_logged = $_SESSION['user_logged'];

//Test jestli je uzivatel prihlasen
if($user_logged == '1')
{


if(isset($_GET['action'])) $get_action = mysqli_real_escape_string($conn,$_GET['action']);
if(isset($_GET['id'])) $get_id = mysqli_real_escape_string($conn,$_GET['id']);



echo '<div class="container">'."\n";

echo '<h1>Správa uživatelů</h1>'."\n";

echo '<h3 class="text-right"><span class="badge badge-secondary">
Přihlášený uživatel: '.$user_login.' <a style="color:#ccc;" 
href="./admin.php?login_action=logout">odhlásit</a></span></h3>'."\n";


//vkladani uzivatelu
if(isset($get_action) and $get_action == 'insert')
{
  echo "vkladani";
}
//editace uzivatelu
elseif(isset($get_action) and $get_action == 'edit')
{
  
}

elseif(isset($get_action) and $get_action == 'delete')
{
    $sql_delete = mysqli_query($conn,'DELETE FROM '._TABLE_USERS.' where id = "'.$get_id.'"')
    or print("<p>Uživatel nebyl smazán.</p>");
    if($sql_delete)
    {
        echo '<div class="alert alert-success" role="alert">';
        echo '<p class="text-center">User deleted</p>';
        echo '</div>';
        echo '<p><a class="btn btn-success" href="./admin.php">Zpět na výpis uživatelů</a></p>'."\n";
    }
}
else
{

echo '<p><a class="btn btn-success" href="./admin.php?action=insert">Vložit nového uživatele</a></p>'."\n";
$result_users=mysqli_query($conn,'select * from '._TABLE_USERS.' where id!=11 order by id');   
if(mysqli_num_rows($result_users) > 0)
{
echo '<table class="table table-bordered table-striped table-hover">'."\n";
echo '<tr>'."\n";
    echo '<th>ID</th>'."\n";
    echo '<th>Jméno</th>'."\n";
    echo '<th>Příjmení</th>'."\n";
    echo '<th>E-mail</th>'."\n";
    echo '<th>Ulice</th>'."\n";
    echo '<th>Město</th>'."\n";
    echo '<th>PSČ</th>'."\n";
    echo '<th>Pohlaví</th>'."\n";
    echo '<th>Poznámka</th>'."\n"; 
    echo '<th>Akce</th>'."\n";
echo '</tr>'."\n";
while ($entry=mysqli_fetch_array($result_users))
{
  echo '<tr>'."\n";
    echo '<td>'.$entry['id'].'</td>'."\n";
    echo '<td>'.$entry['name'].'</td>'."\n";
    echo '<td>'.mb_strtoupper($entry['surname'],'UTF-8').'</td>'."\n";    
    echo '<td>'.$entry['email'].'</td>'."\n";
    echo '<td>'.$entry['street'].'</td>'."\n";
    echo '<td>'.$entry['city'].'</td>'."\n";
    echo '<td>'.$entry['zip'].'</td>'."\n";
    if($entry['sex'] == 'male') echo '<td>muž</td>'."\n";
    elseif($entry['sex'] == 'female') echo '<td>žena</td>'."\n";
    echo '<td>'.$entry['note'].'</td>'."\n";
    echo '<td><a href="admin.php?action=delete&id='.$entry['id'].'" class="btn btn-primary">Smazat</a>' . "\n";
  echo '</tr>'."\n";  
}
echo '</table>'."\n";
}
else
{
  echo '<p><b>Nebyly nalezeny žádné záznamy.</b></p>'."\n";  
}
}

mysqli_close($conn); 

}
else
{
    $location = './index.php';
    if (!headers_sent())
    {
      Header("Location: $location");
    }
    else
    {
      echo '<script type="text/javascript">';
      echo 'window.location.href="'.$location.'";';
      echo '</script>';
      echo '<noscript>';
      echo '<meta http-equiv="refresh" content="0;url='.$location.'" />';
      echo '</noscript>';
    }
}

echo '</div>'."\n";
echo '</body>'."\n";
echo '</html> '."\n";

?>