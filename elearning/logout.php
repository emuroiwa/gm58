<?php 
session_start();
 include "opendb.php";
   
     $date = date('m/d/Y'); $time = date('m/d/Y-h:m:s');
	 $res = mysql_query("insert into audit_tray(username,operation,time,date,login) values('$_SESSION[username]','Logged Out','$time','$date','logout')") or die(mysql_error());
	 
unset($_SESSION['username']);
unset($_SESSION['name']);
unset($_SESSION['reg']);
unset($_SESSION['term']);
unset($_SESSION['year']);


session_unset();
session_destroy();

header("location:index.php");
?>