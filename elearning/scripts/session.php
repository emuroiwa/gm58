<?php   
session_start();
$_SESSION['reg']=$_GET['reg'];
 header("location: index.php?page=../student/coursewk1.php&date=$_GET[date]&name=$_GET[name]&surname=$_GET[surname]&reg=$_GET[reg]"); 
 
 //echo ("");  
			
 ?>Binding Security.........<SCRIPT LANGUAGE='JavaScript'>
		 location='index.php?page=../student/coursewk1.php&date=$_GET[date]&name=$_GET[name]&surname=$_GET[surname]&reg=$_GET[reg]'
		 	</SCRIPT>