<?php    

$result1 = mysql_query("SELECT * FROM `class`,users,student_class WHERE class.teacher not in(select final.ecnumber from final where year='$_SESSION[year]' and term='$_SESSION[term]') AND class.teacher=users.username AND class.level=student_class.level AND class.name=student_class.class GROUP BY username order by class.name asc,class.level asc")or die(mysql_query());
 $rows = mysql_num_rows($result1);
if($rows==0)
 {
 	echo("<center><br><br><br><br><br><h4>All teachers have finalised student reports<br>
Proceed and click <a href='head.php?page=head_class.php'>Finalised Reports</a> to enter students remark</h4>
<br><br><br><br><br><br><br><br><br><br><br>");  
			exit; 	  
 }
 ?><center><h5>Until Reports from these classes are FINALIZED you can not publish results. Thank You....</h5><table border="1"><tr bgcolor="#FFFFFF"><td><strong>Class</strong></td><td><strong> Surname Name</strong></td><td><strong>STATUS</strong></td></tr><?php
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))
{
	
$level=$row1['level'];
 
$class=$row1['name'];
$surname=$row1['surname'];
$name=$row1['namee'];
$id=$row1['teacher'];

print "<tr><td>$level $class</td><td>$surname $name</td><td bgcolor='red'> PENDING</td></tr>
";
}
?></table>