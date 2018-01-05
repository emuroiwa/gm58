<center><table border="1"><tr bgcolor="#FFFFFF"><td><strong>Student Number</strong></td><td><strong>Name and Surname</strong></td><td><strong>Click Pending Correction Below</strong></td><td><strong>Click When Corrected</strong></td></tr><?php 
   $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}

$sq1=mysql_query("select * from correct,student where session='$_SESSION[year]' and term='$_SESSION[term]' and ecnumber='$_SESSION[username]' and subject_id='head' and student=reg and correct.status='pending'  " );
 $result1 = mysql_query("SELECT * FROM student_class,student where student_class.level='$grd' and student_class.student=student.reg and class='$class' order by surname asc")or die(mysql_query());
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))
{
$reg=$row1['student'];
 
$name=$row1['name'];
$surname=$row1['surname'];
$level=$row1['level'];
$id=$row1['id'];}

// $remarkrows = mysql_num_rows($rem);
	
$a=0;
while($row=mysql_fetch_array($sq1,MYSQL_ASSOC)){
	$id=$row['idc'];

	$student=$row['name']." ".$row['surname'];
	//echo"<a href='index.php?page=tab.php&level=$level&reg=$reg&name=$name&surname=$surname 'target='_blank'><strong>(click here)Pending corrections to be made for $student</strong></a>";
	
$a++;
	$link="<tr><td>$row[reg]</td><td>$student</td><td> <a href='index.php?page=tab.php&level=$level&reg=$reg&name=$name&surname=$surname 'target='_blank'><strong>$row[remark] </strong></a></td><td> <a href='index.php?page=updatecorrection.php&money=$id onclick='return confirm('This action cannot be undone. Are you sure you want to proceed?');''><strong>Corrected</strong></a></td></tr>";
		
		print "   $link";}
	?></table><!--<a href="" onClick="return confirm('This action cannot be undone. Are you sure you want to proceed?');'">kdhk</a>-->