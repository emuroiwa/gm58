<center><h5>UNTIL ALL CORRECTIONS ARE SORTED YOU CAN NOT PUBLISH RESULTS</h5><br>
<table border="1"><tr bgcolor="#FFFFFF"><td><strong>EC Number</strong></td><td><strong>Name and Surname</strong></td><td><strong>Pending Correction </strong></td><td><strong>Student </strong></td></tr><?php 
   $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}

$sql1=mysql_query("select * from correct,users where session='$_SESSION[year]' and term='$_SESSION[term]' and correct.ecnumber=users.username and correct.status='pending'  " );

 while($row1 = mysql_fetch_array($sql1, MYSQL_ASSOC))
{
$reg=$row1['student'];
 
$surname=$row1['surname'];
$ec=$row1['ecnumber'];
$id=$row1['id'];

// $remarkrows = mysql_num_rows($rem);
	
	$id=$row1['idc'];

	$student=$row1['namee']." ".$row1['surname'];
	//echo"<a href='index.php?page=tab.php&level=$level&reg=$reg&name=$name&surname=$surname 'target='_blank'><strong>(click here)Pending corrections to be made for $student</strong></a>";
	

	$link="<tr><td>$ec</td><td>$student</td><td><strong>$row1[remark] </strong></td><td>$row1[student]</td></tr>";
		
		print "   $link";}
	?></table><!--<a href="" onClick="return confirm('This action cannot be undone. Are you sure you want to proceed?');'">kdhk</a>-->