<?php
$conn=@mysqli_connect(_DB_HOST,_DB_USER,_DB_PASSWORD) or die(_DB_ERROR_CONNECT_DB);
$sele=mysqli_select_db($conn,_DB_NAME) or die(_DB_ERROR_SELECT_DB);
@mysqli_query("SET NAMES 'utf8'", $conn);
$conn->set_charset("utf8");