<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<center><table border="1"><tr bgcolor="#FFFFFF"><td><strong>Student Number</strong></td><td><strong>Surname Name</strong></td><td><strong>STATUS</strong></td></tr><?php 
session_start();
unset($_SESSION['reg']);

echo "

Please click <strong>Student Status</strong> to enter student results<br>For term $_SESSION[term] year $_SESSION[year]<br>
 
"; ?>



<?php 
 //$id=$_GET['id'];
 //$subject=$_GET['name'];
 //$term=$_GET['term'];v 

	  
	
	   $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' limit 1 ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];
		//echo $grd;
		}
		if($class=='Shona L1' or $class=='Shona L2' or $class=='Shona L2' or $class=='Extra Mural Activities' or $class=='Extra Mural Activities'){
			
	 $r1 = mysql_query("select * from class where teacher='$_SESSION[username]' ")or die(mysql_query());
   $rowzz = mysql_num_rows($r1);
   if($rowzz==0)
 {
 	echo("No students taking this s adminstrator now");  
			exit;

 	  
 }
  while($row1 = mysql_fetch_array($r1, MYSQL_ASSOC))
	  	  
{
$grd = $row1['level'];
		$class = $row1['name'];

print "<a href='index.php?page=tab.php&level=$level&reg=$reg&name=$name&surname=$surname 'target='_blank'><hr> $grd $class </a>
<br>
";

}
}else{
 	    $session = date('Y');
 $result1 = mysql_query("SELECT * FROM student_class,student where student_class.level='$grd' and student_class.student=student.reg and class='$class' order by sex asc, surname asc")or die(mysql_query());
 $students = mysql_num_rows($result1);
	if($students==0)
 {
 	echo("No students taking this subject please contact the adminstrator now");  
			exit; 	  
 }
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))
{
	
	 $r1 = mysql_query("SELECT * FROM marksbook where  session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$row1[student]'  and date='$_GET[date]' and level='$grd' and class='$class'")or die(mysql_query());
   $rows = mysql_num_rows($r1);
   //checking if results have been published
     $rrrr = mysql_query("SELECT * FROM marksbook where  session='$_SESSION[year]' and term='$_SESSION[term]' and status='1'  and date='$_GET[date]'  and level='$grd' and class='$class'")or die(mysql_query());
   //$rows = mysql_num_rows($r1); 
   $order = mysql_num_rows($rrrr);
  
   

 $reg=$row1['student'];
$name=$row1['name'];
$surname=$row1['surname'];
$level=$row1['level'];
$id=$row1['id'];

print "<tr><td>$reg</td><td>$surname $name</td><td bgcolor='white'><a href='index.php?page=../student/coursewk1.php&date=$_GET[date]&name=$_GET[name]&surname=$_GET[surname]&reg=$reg' target='_blank'>View Marksbook</a></td></tr>";

}
//echo "</table>";echo $rows;  echo $students; exit;

	if(isset($_POST['Publish'])){
		$time=date('m/d/Y-h:m:s');
 mysql_query("update marksbook set status='0' where  session='$_SESSION[year]' and term='$_SESSION[term]' and status='1'  and date='$_GET[date]'  and level='$grd' and class='$class' ") or die (mysql_error()); 
   header("location: index.php?page=students_cw.php&date=$_GET[date]"); 
  }?>

	<form action="" method="post">
  <br>
  <table width="200" border="0"  align="center">
  <tr>
    <td><label><?php
	//checking penging corrections
  

	$rs1=mysql_query("SELECT * FROM marksbook where  session='$_SESSION[year]' and term='$_SESSION[term]' and status='0'  and date='$_GET[date]'  and level='$grd' and class='$class'") or die(mysql_error());	  
$rowzz = mysql_num_rows($rs1);
if ($rowzz>0){
$disabled = "disabled='disabled'";
 $title="MARKS PUBLISHED FOR THIS $_GET[date] ";}
      else{
              $disabled = "";
			  $title="PUBLISH MARKS FOR THIS $_GET[date] ";
       }
echo "<input type='submit' name='Publish', value='                         $title                        ' " . $disabled . "/>";
 
?>
      
    </label></td>
    

</form>
	
	<?php }

?></table>
</body>
</html>