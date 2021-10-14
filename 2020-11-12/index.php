<?php   

require "./configure.php";
require "./connect.php";
require "./session.php";

?>
<html>
<head>
<title>Přihlášení do správy uživatelů</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="screen" href="./bootstrap/css/bootstrap.css" />
</head>
<body>
<div class="container">
<?php


echo '<h1>Přihlašení do správy uživatelů</h1>';


function show_form()
{
     

echo '<form method="post" action="index.php">'."\n";
echo '<input type="hidden" name="form-insert" value="sent">'."\n";

  echo '<div class="form-group row">'."\n";
    echo '<label for="email" class="col-md-2 col-form-label">Email</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="email" id="email" required>'."\n";
    echo '</div>'."\n";
  echo '</div>'."\n";
  
  echo '<div class="form-group row">'."\n";
    echo '<label for="password" class="col-md-2 col-form-label">Heslo</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="password" class="form-control" name="password" id="password" required>'."\n";
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
    
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $cont = false;
    $result_user_login=mysqli_query($conn,'select * from '._TABLE_USERS.' where email like "'.$email.'" limit 1');
    if(mysqli_num_rows($result_user_login) == 1)
    {
       $cont = true;
       while($entry_user_login = mysqli_fetch_array($result_user_login))
       {
           $user_login = $entry_user_login['email'];
           $user_password = $entry_user_login['password'];
       }
       if($cont and password_verify($password,$user_password))
       {
         $_SESSION['user_logged'] = '1';
         $_SESSION['user_login'] = $user_login;

         $location = './admin.php';

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
       else
       {
         echo '<div class="alert alert-danger" role="alert">';
           echo '<p class="text-center">Špatné přihlašovací údaje</p>';
         echo '</div>';
         show_form();
       }
    }
    else
    {
      echo '<div class="alert alert-danger" role="alert">';
        echo '<p class="text-center">Špatné přihlašovací údaje</p>';
      echo '</div>';
      show_form();
    }
  
    

}
else
{
  show_form();
}



 
?>
</div>
</body>
</html>
