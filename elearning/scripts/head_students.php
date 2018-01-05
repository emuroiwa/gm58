<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<center><table border="1"><tr bgcolor="#FFFFFF"><td><strong>Student Number</strong></td><td><strong>Full Name</strong></td><td><strong>STATUS</strong></td></tr><?php echo "<strong> $_GET[surname] $_GET[name] ($_GET[ec])'s Class Grade $_GET[level] $_GET[class]  <hr></strong>


Please click Student <strong>Student Status</strong> to Print Student <strong>Report</strong><br>
 
"; 
	   $rs1=mysql_query("select * from class where teacher='$_GET[ec]' limit 1 ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];
		//echo $grd;
		}
 	    $session = date('Y');
 $result1 = mysql_query("SELECT * FROM student_class,student where student_class.level='$grd' and student_class.student=student.reg and class='$class' and status='ENROLLED' order by sex asc,surname asc")or die(mysql_query());
 $rows = mysql_num_rows($result1);
	if($rows==0)
 {
 	echo("No students taking this subject please contact the adminstrator now");  
			exit; 	  
 }
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))
{

   $r12 = mysql_query("SELECT * FROM remarks where  session='$_SESSION[year]' and term='$_SESSION[term]' and student='$row1[student]' and subject_id='head' ")or die(mysql_query());
   $rows1 = mysql_num_rows($r12);
 // echo $rows1;

  
   if($rows1==0){
	 
	   $status="<strong><font color='#FF0000'>Print now...</font></strong>";
	      }
   if($rows1==1){
	   $status="Heads Remark Captured...";
	      }
		
$reg=$row1['student'];
 
$name=$row1['name'];
$surname=$row1['surname'];
$level=$row1['level'];
$id=$row1['id'];

print "<tr><td>$reg</td><td>$surname $name</td><td bgcolor='white'><a href='print/print.php?level=$level&class=$_GET[class]&reg=$reg&name=$name&surname=$surname&teacher=$_GET[ec] 'target='_blank'>  $status</a></td></tr>

";

}  ?></table>
</body>
</html>