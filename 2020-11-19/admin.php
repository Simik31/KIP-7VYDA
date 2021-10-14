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
  //vkladani
  if(isset($_POST['form-insert']) and $_POST['form-insert'] == 'sent')
  {
    $pass = $_POST['password'];
    $hash_pass = password_hash($pass,PASSWORD_BCRYPT);

    $sql_insert = mysqli_query($conn, 'INSERT INTO '._TABLE_USERS.' (id,name,surname,email,password,street,city,zip,region_id,country_id,sex,note)
    VALUES ("","'.$_POST['name'].'","'.$_POST['surname'].'", "'.$_POST['email'].'","'.$hash_pass.'", "'.$_POST["street"].'", "'.$_POST["city"].'", "'.$_POST["zip"].'", "'.$_POST["region_id"].'", "'.$_POST["country_id"].'", "'.$_POST["sex"].'", "'.$_POST["note"].'")')
    or print("<p>Uživatel nebyl vložen.</p>");
    if($sql_insert)
    {
       echo '<div class="alert alert-success" role="alert">';
         echo '<p class="text-center">Uživatel byl úspěšně vložen.</p>';
       echo '</div>';
       echo '<div class="alert alert-success" role="alert">';
         echo '<p class="text-center"><a href="./admin.php">Zpět na seznam uživatelů</a></p>';
       echo '</div>';
    }
  }
  else
  {

    echo '<h2>Vložení nového uživatele</h2>'."\n";
    

    echo '<form method="post" action="admin.php?action=insert">'."\n";
    echo '<input type="hidden" name="form-insert" value="sent">'."\n";

  
    echo '<div class="form-group row">'."\n";
      echo '<label for="email" class="col-md-2 col-form-label">Email</label>'."\n";
      echo '<div class="col-md-10">'."\n";
        echo '<input type="email" class="form-control" name="email" id="email" required>'."\n";
      echo '</div>'."\n"; 
    echo '</div>'."\n";
  
  
    echo '<div class="form-group row">'."\n";
      echo '<label for="password" class="col-md-2 col-form-label">Heslo</label>'."\n";
      echo '<div class="col-md-10">'."\n";
        echo '<input type="password" class="form-control" name="password" id="password" required>'."\n";
      echo '</div>'."\n";
    echo '</div>'."\n"; 
  
 
    echo '<div class="form-group row">'."\n";
    echo '<label for="name" class="col-md-2 col-form-label">Jméno</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="name" id="name" required>'."\n";
    echo '</div>'."\n";
    echo '</div>'."\n"; 
  
  
    echo '<div class="form-group row">'."\n";
    echo '<label for="surname" class="col-md-2 col-form-label">Přijmení</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="surname" id="surname" required>'."\n";
    echo '</div>'."\n";
    echo '</div>'."\n"; 

    echo '<div class="form-group row">'."\n";
    echo '<label for="sex" class="col-md-2 col-form-label">Pohlaví</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<div class="form-check form-check-inline">'."\n";
      echo '<input type="radio" class="form-check-input" name="sex" value="male" checked="checked"><label class="form-check-label">muž</label>'."\n";
      echo '</div>'."\n";
      echo '<div class="form-check form-check-inline">'."\n";
      echo '<input type="radio" class="form-check-input" name="sex" value="female"><label class="form-check-label">žena</label>'."\n";
      echo '</div>'."\n";
    echo '</div>'."\n";
    echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="street" class="col-md-2 col-form-label">Ulice</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="street" id="street" required>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="city" class="col-md-2 col-form-label">Město</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="city" id="city" required>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="zip" class="col-md-2 col-form-label">PSČ</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<input type="number" class="form-control" name="zip" id="zip" required>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="region_id" class="col-md-2 col-form-label">Kraj</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<select class="form-control" name="region_id">'."\n";
      $result_regions=mysqli_query($conn,'select * from '._TABLE_REGIONS.' order by id');
      while ($entry=mysqli_fetch_array($result_regions)) {
          echo '<option value="'.$entry["id"].'">'.$entry["name"].'</option>'."\n";
      }
      echo '</select>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="country_id" class="col-md-2 col-form-label">Země</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<select class="form-control" name="country_id">'."\n";
      $result_countries=mysqli_query($conn,'select * from '._TABLE_COUNTRIES.' order by id');
      while ($entry=mysqli_fetch_array($result_countries)) {
          echo '<option value="'.$entry["id"].'">'.$entry["name"].'</option>'."\n";
      }
      echo '</select>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="note" class="col-md-2 col-form-label">PSČ</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<textarea class="form-control" name="note" id="note" required></textarea>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";
 
    echo '<div class="form-group row">'."\n";
    echo '<label for="note" class="col-md-2 col-form-label">&nbsp;</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="submit" class="btn btn-success" name="submit" value="Vložit">'."\n";
    echo '</div>'."\n";
    echo '</div>'."\n";


    echo '</form>'."\n";
  }

}
elseif(isset($get_action) and $get_action == 'edit')
{
  //editace
  if(isset($_POST['form-edit']) and $_POST['form-edit'] == 'sent')
  {
      $result_user=mysqli_query($conn,'select * from '._TABLE_USERS.' where id = '.$get_id.' limit 1');
      while($entry_user=mysqli_fetch_array($result_user)) {
        $user_old_password = $entry_user["password"];
      }

      if($_POST["password"] === $user_old_password) {
          $new_password = false;
      } else {
          $new_password = true;
          $user_password = password_hash($_POST["password"], PASSWORD_BCRYPT);
      }

    $sql_update = mysqli_query($conn, 'UPDATE '._TABLE_USERS.' SET 
    '.($new_password ? 'password="'.$user_password.'",' : '').'
    name="'.$_POST['name'].'",
    surname="'.$_POST['surname'].'",
    street="'.$_POST["street"].'",
    city="'.$_POST["city"].'",
    zip="'.$_POST["zip"].'",
    region_id="'.$_POST["region_id"].'",
    country_id="'.$_POST["country_id"].'",
    sex="'.$_POST["sex"].'",
    note="'.$_POST["note"].'"
    WHERE id="'.$get_id.'"') or print("<p>Uživatel nebyl upraven</p>");
    if($sql_update)
    {
       echo '<div class="alert alert-success" role="alert">';
         echo '<p class="text-center">Uživatel byl úspěšně editován.</p>';
       echo '</div>';
       echo '<div class="alert alert-success" role="alert">';
         echo '<p class="text-center"><a href="./admin.php">Zpět na seznam uživatelů</a></p>';
       echo '</div>';
    }
  }
  else
  {

    echo '<h2>Editace uživatele</h2>'."\n";
    $result_user=mysqli_query($conn,'select * from '._TABLE_USERS.' where id = '.$get_id.' limit 1');
    while($entry_user=mysqli_fetch_array($result_user)) 
    {
      $user_email = $entry_user['email'];
      $user_password = $entry_user["password"];
      $user_name = $entry_user['name'];
      $user_surname = $entry_user['surname'];
      $user_sex = $entry_user["sex"];
      $user_street = $entry_user["street"];
      $user_city = $entry_user["city"];
      $user_zip = $entry_user["zip"];
      $user_region_id = $entry_user["region_id"];
      $user_country_id = $entry_user["country_id"];
      $user_note = $entry_user["note"];
    }
    

    echo '<form method="post" action="admin.php?action=edit&id='.$get_id.'">'."\n";
      echo '<input type="hidden" name="form-edit" value="sent">'."\n";


      echo '<div class="form-group row">'."\n";
      echo '<label for="email" class="col-md-2 col-form-label">Email</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<input type="email" class="form-control" name="email" id="email" value="'.$user_email.'" disabled>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="password" class="col-md-2 col-form-label">Heslo</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<input type="password" class="form-control" name="password" id="password" value="'.$user_password.'" required>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="name" class="col-md-2 col-form-label">Jméno</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="name" id="name" value="'.$user_name.'" required>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";


      echo '<div class="form-group row">'."\n";
      echo '<label for="surname" class="col-md-2 col-form-label">Přijmení</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="surname" id="surname" value="'.$user_surname.'" required>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="sex" class="col-md-2 col-form-label">Pohlaví</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<div class="form-check form-check-inline">'."\n";
      echo '<input type="radio" class="form-check-input" name="sex" value="male" '.($user_sex === "male" ? "checked" : "").'><label class="form-check-label">muž</label>'."\n";
      echo '</div>'."\n";
      echo '<div class="form-check form-check-inline">'."\n";
      echo '<input type="radio" class="form-check-input" name="sex" value="female" '.($user_sex === "female" ? "checked" : "").'><label class="form-check-label">žena</label>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="street" class="col-md-2 col-form-label">Ulice</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="street" id="street" value="'.$user_street.'" required>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="city" class="col-md-2 col-form-label">Město</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="city" id="city" value="'.$user_city.'" required>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="zip" class="col-md-2 col-form-label">PSČ</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<input type="number" class="form-control" name="zip" id="zip" value="'.$user_zip.'" required>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="region_id" class="col-md-2 col-form-label">Kraj</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<select class="form-control" name="region_id">'."\n";
      $result_regions=mysqli_query($conn,'select * from '._TABLE_REGIONS.' order by id');
      while ($entry=mysqli_fetch_array($result_regions)) {
          echo '<option value="'.$entry["id"].'" '.($user_region_id === $entry["id"] ? "selected" : "").'>'.$entry["name"].'</option>'."\n";
      }
      echo '</select>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="country_id" class="col-md-2 col-form-label">Země</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<select class="form-control" name="country_id">'."\n";
      $result_countries=mysqli_query($conn,'select * from '._TABLE_COUNTRIES.' order by id');
      while ($entry=mysqli_fetch_array($result_countries)) {
          echo '<option value="'.$entry["id"].'" '.($user_country_id === $entry["id"] ? "selected" : "").'>'.$entry["name"].'</option>'."\n";
      }
      echo '</select>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="note" class="col-md-2 col-form-label">PSČ</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<textarea class="form-control" name="note" id="note" required>'.$user_note.'</textarea>'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";

      echo '<div class="form-group row">'."\n";
      echo '<label for="note" class="col-md-2 col-form-label">&nbsp;</label>'."\n";
      echo '<div class="col-md-10">'."\n";
      echo '<input type="submit" class="btn btn-success" name="submit" value="Vložit">'."\n";
      echo '</div>'."\n";
      echo '</div>'."\n";


      echo '</form>'."\n";
  
  }
}
//mazani uzivatelu
elseif(isset($get_action) and $get_action == 'delete')
{
  $sql_delete = mysqli_query($conn,'DELETE FROM '._TABLE_USERS.' where id = "'.$get_id.'"')
  or print("<p>Uživatel nebyl smazán.</p>");
  if($sql_delete)
  {
    echo '<div class="alert alert-success" role="alert">';
      echo '<p class="text-center">Uživatel byl úspěšně smazán.</p>';
    echo '</div>'; 
    echo '<div class="alert alert-primary" role="alert">';
      echo '<p class="text-center"><a href="./admin.php">Zpět na výpis uživatelů</a></p>';
    echo '</div>'; 
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
    else echo '<td>neuvedeno</td>'."\n";
    echo '<td>'.$entry['note'].'</td>'."\n";
    echo '<td><a class="btn btn-info" href="./admin.php?action=edit&id='.$entry['id'].'">editovat</a><br><br>
    <a class="btn btn-danger" href="./admin.php?action=delete&id='.$entry['id'].'">smazat</a></td>'."\n";
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