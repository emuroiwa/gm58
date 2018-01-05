ss<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<center><?php 

   $nguva=date('m/d/Y');
   if($_POST['date'] > $nguva)
{
echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Invalid Date')
		 location='index.php?page=coursework.php'
		 	</SCRIPT>");  
			}

 ?>



<?php 
 $dateyacho=$_POST['date'];
 
 $type=$_POST['type']; 

	  
	
	   $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];
		}
		///echo $grd; exit;
 	    $session = date('Y');
 $result1 = mysql_query("SELECT * FROM student_class,student where student_class.level='$grd' and student_class.class='$class' and student_class.student=student.reg order by surname desc")or die(mysql_query());
 $rows = mysql_num_rows($result1);
	if($rows==0)
 {
 	echo("No students taking this subject please contact the adminstrator now");  
			exit;

 	  
 }echo "Please click Student <strong>Number Name and Surname</strong> to enter student results for <br>
$_POST[type]<br>Written on $_POST[date]<br>
For term $_SESSION[term]  $_SESSION[year]";
 print "<table align='center' border='0'>";
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))
	  	  
{
$reg=$row1['student'];
$name=$row1['name'];
$surname=$row1['surname'];
$level=$row1['level'];
$id=$row1['id'];
print "<tr><td>{$reg}</td><td>{$surname}</td><td>{$name}</td><td><a href='index.php?page=newtab.php&level=$level&reg=$reg&name=$name&surname=$surname&date=$dateyacho&de=$type' target='_blank'> CAPTURE MARK </a></td></tr>
<br>
";

}
?></table>
</body>
</html>