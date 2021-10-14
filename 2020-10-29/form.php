<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);


echo '<html>'."\n";
echo '<head>'."\n";
echo '<title>Registrační formulář</title>'."\n";
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />'."\n";
echo '<link rel="stylesheet" type="text/css" media="screen" href="./bootstrap/css/bootstrap.css" />'."\n";
echo '<link rel="stylesheet" type="text/css" media="screen" href="./styl.css" />'."\n";
echo '</head>'."\n";
echo '<body>'."\n";

echo '<div class="container">'."\n";

echo '<h1>Registrační formulář</h1>'."\n";


function show_form()
{
     

echo '<form method="post" action="form.php">'."\n";
echo '<input type="hidden" name="form-insert" value="sent">'."\n";

  echo '<div class="form-group row">'."\n";
    echo '<label for="email" class="col-md-2 col-form-label">Email</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="email" id="email" size="25" maxlength="25">'."\n";
    echo '</div>'."\n";
  echo '</div>'."\n";
  
  echo '<div class="form-group row">'."\n";
    echo '<label for="password" class="col-md-2 col-form-label">Heslo</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="password" class="form-control" name="password" id="password">'."\n";
    echo '</div>'."\n";
  echo '</div>'."\n";
  
  echo '<div class="form-group row">'."\n";
    echo '<label for="password2" class="col-md-2 col-form-label">Potvrzení hesla</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="password" class="form-control" name="password2" id="password2">'."\n";
    echo '</div>'."\n";
  echo '</div>'."\n";
  
  echo '<div class="form-group row">'."\n";
    echo '<label for="name" class="col-md-2 col-form-label">Jméno</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="name" id="name" required>'."\n"; 
    echo '</div>'."\n";
  echo '</div>'."\n";
  
  echo '<div class="form-group row">'."\n";
    echo '<label for="surname" class="col-md-2 col-form-label">Příjmení</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="surname" id="surname" required>'."\n";
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
    echo '<label for="region" class="col-md-2 col-form-label">Kraj</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<select name="region" class="form-control">'."\n";
      echo '<option value="praha">Hlavní město praha</option>'."\n";
      echo '<option value="stredocesky">Středočeský</option>'."\n";
      echo '<option value="liberecky">Liberecký</option>'."\n";
      echo '<option value="ustecky">Ústecký</option>'."\n";
      echo '<option value="karlovarsky">Karlovarský</option>'."\n";
      echo '<option value="plzensky">Plzeňský</option>'."\n";
      echo '<option value="jihocesky">Jihočeský</option>'."\n";
      echo '<option value="pardubicky">Pardubický</option>'."\n";
      echo '<option value="kralovehradecky">Královéhradecký</option>'."\n";
      echo '<option value="vysocina">Vysočina</option>'."\n";
      echo '<option value="jihomoravsky">Jihomoravský</option>'."\n";
      echo '<option value="olomoucky">Olomoucký</option>'."\n";
      echo '<option value="moravskoslezsky">Moravskoslezský</option>'."\n";
      echo '<option value="zlinsky">Zlínský</option>'."\n";
      echo '</select>'."\n";
    echo '</div>'."\n";
  echo '</div>'."\n";



  echo '<div class="form-group row">'."\n";
    echo '<label for="sex" class="col-md-2 col-form-label">Pohlaví</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="radio" name="sex" value="male" checked>  muž <input type="radio" name="sex" id="sex" value="female">  žena'."\n";
    echo '</div>'."\n";
  echo '</div>'."\n";
  
    echo '<div class="form-group row">'."\n";
    echo '<label for="note" class="col-md-2 col-form-label">Poznámka</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<textarea class="form-control" id="note" name="note" rows="4" cols="50"></textarea>'."\n";
    echo '</div>'."\n";
  echo '</div>'."\n";
  
  
  echo '<div class="form-group row">'."\n";
    echo '<label for="note" class="col-md-2 col-form-label">&nbsp;</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="submit" class="btn btn-success" name="submit" value="Odeslat">'."\n";
    echo '</div>'."\n";
  echo '</div>'."\n";

echo '</form>'."\n";

}



if(isset($_POST['form-insert']) and $_POST['form-insert'] == 'sent')
{


   $regions =array("praha"=>"Hlavní město praha",
   "stredocesky"=>"Středočeský","liberecky"=>"Liberecký","ustecky"=>"Ústecký","karlovarsky"=>"Karlovarský",
   "plzensky"=>"Plzeňský","jihocesky"=>"Jihočeský","pardubicky"=>"Pardubický","kralovehradecky"=>"Královéhradecký",
   "vysocina"=>"Vysočina","olomoucky"=>"Olomoucký","moravskoslezsky"=>"Moravskoslezský","zlinsky"=>"Zlínský",
   "jihomoravsky"=>"Jihomoravský");

    echo '<div class="alert alert-success" role="alert">'."\n";
    echo '<p class="text-center">E-mail: '.$_POST['email'].'</p>'."\n";
    echo '<p class="text-center">Heslo: '.$_POST['password'].'</p>'."\n";
    echo '<p class="text-center">Potvrzení hesla: '.$_POST['password2'].'</p>'."\n";
    echo '<p class="text-center">Jméno: '.$_POST['name'].'</p>'."\n"; 
    echo '<p class="text-center">Příjmení: '.$_POST['surname'].'</p>'."\n";
    echo '<p class="text-center">Ulice: '.$_POST['street'].'</p>'."\n";
    echo '<p class="text-center">Město: '.$_POST['city'].'</p>'."\n";
    echo '<p class="text-center">PSČ: '.$_POST['zip'].'</p>'."\n";
    echo '<p class="text-center">Kraj: '.$regions[$_POST['region']].'</p>'."\n";
    echo '<p class="text-center">Pohlaví: ';
    if($_POST['sex'] =='male' ) echo 'muž';
    elseif($_POST['sex'] =='female' ) echo 'žena';
    echo '<p class="text-center">Poznámka: '.$_POST['note'].'</p>'."\n"; 
    echo '</div>'."\n"; 


}
else
{
  show_form();
}


echo '</div>'."\n";
echo '</body>'."\n";
echo '</html> '."\n";
?>