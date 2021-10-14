<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

session_start();

if(isset($_GET['login_action'])) $get_login_action = mysqli_real_escape_string($conn,$_GET['login_action']);
if($get_login_action == 'logout')
{
  unset($_SESSION['user_logged']);
  unset($_SESSION['user_login']);
}
