<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body><center><table border="1"><tr bgcolor="#FFFFFF"><td><strong>Student Number</strong></td><td><strong>Surname Name</strong></td><td><strong>Overall Average</strong></td><td><strong>Position</strong></td></tr>
<?php 
  $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$level = $row1['level'];
		$class = $row1['name'];}
 $result1 = mysql_query("SELECT * FROM student_class,student where student_class.level='$level' and student_class.student=student.reg and class='$class'")or die(mysql_query());
 $students = mysql_num_rows($result1);
	if($students==0)
 {
 	echo("No students taking this subject please contact the adminstrator now");  
			exit; 	  
 }
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))
{
mysql_query("SET @row=0");
$pos=mysql_query("SELECT student,pos,average FROM (SELECT @row := @row+1 AS pos,student,average FROM average  where
 session='$_SESSION[year]' and `term`='$_SESSION[term]'  and subject_id = 'OVERALL' and grade = '$level' and class = '$class' ORDER BY average DESC) as n where student='$row1[student]' ORDER BY student DESc ");
  while($rowpos = mysql_fetch_array($pos, MYSQL_ASSOC)){
  $position=$rowpos['pos'];
  $reg=$rowpos['student'];
  $avg=$rowpos['average'];
  $name=$row1['name'];
$surname=$row1['surname'];
  
  
 print "<tr><td>$reg</td><td>$surname $name</td><td>$avg</td><td>$position</td></tr>";}} 
?></table>
</body>
</html>