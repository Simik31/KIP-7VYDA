<?php
$conn=@mysqli_connect($cfg['db_host'],$cfg['db_user'],$cfg['db_pass']) or die($cfg['error_con']);
$sele=mysqli_select_db($conn,$cfg['db_name']) or die($cfg['error_sele']);
@mysqli_query("SET NAMES 'utf8'", $conn);
$conn->set_charset("utf8");