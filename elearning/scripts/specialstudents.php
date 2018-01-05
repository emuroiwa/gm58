<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<center><?php echo "
<br>

Please click Student <strong>Number Name and Surname</strong> to enter student results<br>For term $_SESSION[term]  $_SESSION[year]<br>
 
"; ?>



<?php 
 //$id=$_GET['id'];
 //$subject=$_GET['name'];
 //$term=$_GET['term'];v 

	  
	
	   $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];
		//echo $grd;
		}
 	    $session = date('Y');
 $result1 = mysql_query("SELECT * FROM student_class,student where student_class.level='$grd' and student_class.student=student.reg and class='$class' order by surname desc")or die(mysql_query());
 $rows = mysql_num_rows($result1);
	if($rows==0)
 {
 	echo("No students taking this subject please contact the adminstrator now");  
			exit;

 	  
 }
/* print'<table><tr><td>Student Number</td><td>Student Number</td><td>Student Number</td>';
*/ while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))
	  	  
{
$reg=$row1['student'];
$name=$row1['name'];
$surname=$row1['surname'];
$level=$row1['level'];
$id=$row1['id'];

print "<a href='index.php?page=tab.php&level=$level&reg=$reg&name=$name&surname=$surname 'target='_blank'><hr> $reg $surname $name</a>
<br>
";

}
?>
</body>
</html>