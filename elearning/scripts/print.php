<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

<center><strong>Maths</strong><hr></center>
<?php $date = date('m/d/Y');
include ('opendb.php');include ('aut.php');
 include '../student/mathsresult12.php'?>
<center><hr><strong>English</strong><hr></center>
<?php include '../student/englishresult1.php'?>
<center><hr><strong>Content</strong><hr></center>
<?php include '../student/contentresult1.php'?>
<center><hr><strong>Shona</strong><hr></center>
<?php include '../student/shona1.php'?>
<center><hr><strong>Other Subjects</strong><hr></center>
<?php include '../student/other1.php'?>
<center><hr><strong>WORK AND SOCIAL HABITS</strong><hr></center>
<p align="left"><?php include 'behave.php'?></p>
<center><hr><strong>SOCIAL ATTITUDES</strong><hr></center>
<p align="left"><?php include 'behave1.php'?></p>
<center><hr><strong>Extra Mural Activities</strong><hr></center>
<?php include '../student/extra1.php';
		  ?>
</body>
</html>
