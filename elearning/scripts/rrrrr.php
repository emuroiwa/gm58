<table border="1"><?php 
 $year=$_SESSION['year'];
  $term=$_SESSION['term'];
$query1 = mysql_query("SELECT *
FROM student_class,student,class
WHERE
student_class.`level` = class.`level` AND
student_class.student = student.reg AND
student_class.class = class.`name` AND
class.teacher = '7777'
ORDER BY
student.sex ASC,
student.surname ASC")or die(mysql_query());

 while($row1 = mysql_fetch_array($query1, MYSQL_ASSOC))
{
$reg= $row1['student'];}

	  $rs1=mysql_query("select * from subjects where subject='english' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$type = $row1['type'];
	

   $aa = mysql_query("SELECT Sum(results.mark) as n FROM results where subject_id='english' and subject='$type' and session='$year' and term='$term' and class='A' and level='7'   ")or die(mysql_query());
 while($aarw = mysql_fetch_array($aa, MYSQL_ASSOC)){
  $spellingavg=$aarw['n'];
  $spelling=round($spellingavg/mysql_num_rows($query1), 2);
  $table.= "<tr><td>$spelling</td>"; 
  }
}	  

$rs1=mysql_query("select * from subjects where subject='english' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$type = $row1['type'];
	

   $aa = mysql_query("SELECT Sum(results.mark) as n FROM results where subject_id='english' and subject='$type' and session='$year' and term='$term'  and level='7'   ")or die(mysql_query());
 while($aarw = mysql_fetch_array($aa, MYSQL_ASSOC)){
  $spellingavg=$aarw['n'];
  $spelling=round($spellingavg/mysql_num_rows($query1), 2);
  $table.="<td>$spelling</td></tr>"; 
  
  }
}
echo $table;
?>
</table>
