<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
 //checking if the head abate vese
   $r12 = mysql_query("SELECT * FROM remarks where  session='$_SESSION[year]' and term='$_SESSION[term]' and subject_id='head' ")or die(mysql_query());
   $rows1 = mysql_num_rows($r12);
 
  //checking number of students enrolled
 $check = mysql_query("SELECT * FROM student_class where level!='COMPLETED' ")or die(mysql_query());
   $num_students = mysql_num_rows($check);
 
   //checking if the head entered all remarks for all students
//echo $rows1;echo $num_students; exit;
// CHECKING IF THERE ARE NO PENING CORRECTIONS
$pending=mysql_query("select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and status='pending' ") or die(mysql_error());	  
$rowpending = mysql_num_rows($pending); 

 $session = date('Y');
 $result1 = mysql_query("SELECT * FROM class,users,final where class.teacher=users.username and class.teacher=final.ecnumber and year='$_SESSION[year]' and term='$_SESSION[term]' order by name asc,level asc")or die(mysql_query());
 $rows = mysql_num_rows($result1);
	if($rows==0)
 {
 	echo("<h5><font color='#FF0000'><br><br><br><br><br>No Student Reports have finalized by respective class teachers<br><br><br><br><br> </font></h5>");  
			exit; 	  
 }?><h5>Please click on each class status to view students in each class</h5><table border="1"><tr bgcolor="#FFFFFF"><td><strong>Class</strong></td><td><strong>Name Surname</strong></td><td><strong>STATUS</strong></td></tr><?php
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))
{
	 
   $r12 = mysql_query("SELECT * FROM `remarks`,class,student_class WHERE remarks.student = student_class.student AND 
student_class.`level` = class.`level` AND  student_class.class = class.`name` and remarks.session='$_SESSION[year]' and remarks.term='$_SESSION[term]' and subject_id='head' and remarks.teacher='$row1[teacher]'")or die(mysql_query());
   $rows1 = mysql_num_rows($r12);
   //checking heads remarks captured for the specfic class
    
	
 	
 $resultt1 = mysql_query("SELECT * FROM student_class where student_class.level='$row1[level]'  and class='$row1[name]' ")or die(mysql_query());	
 $rowzs = mysql_num_rows($resultt1);
   
//echo $rows1; echo $rowzs; exit;
   if($rows1==0 ){
	 
	// $pic='<img src="../images/finished.jpg" height="20" width="20">';
	   $status='Start Capturing';
	      }
   elseif($rows1==$rowzs){
	   $status='Captured';
	      }
 
		  else{
			   $status='Capturing Progress..........';
			  }
$level=$row1['level'];
 
$class=$row1['name'];
$surname=$row1['surname'];
$name=$row1['namee'];
$id=$row1['teacher'];

print "<tr><td>$level $class</td><td>$surname $name</td><td bgcolor='white'><a href='head.php?page=per_class.php&level=$level&class=$class 'target='_blank'>  $status</a></td></tr>";

}
 ?>
</table>

<!--// find out hw many classes anodzidziswa to makesur all reports have been handed to the head-->
</body>
</html>