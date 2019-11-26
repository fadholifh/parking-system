<?php

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_parkir = "localhost";
$database_parkir = "parkir";
$username_parkir = "root";
$password_parkir = "ffh11xx";
$parkir = mysql_pconnect($hostname_parkir, $username_parkir, $password_parkir) or trigger_error(mysql_error(),E_USER_ERROR); 
?>