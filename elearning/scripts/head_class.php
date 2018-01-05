<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
 //checking if the head abate vese
   $r12 = mysql_query("SELECT * FROM remarks,final where  remarks.session='$_SESSION[year]' and remarks.term='$_SESSION[term]' and subject_id='head'  and teacher= ecnumber")or die(mysql_query());
   $rows1 = mysql_num_rows($r12);
 
  //checking number of students enrolled
 $check = mysql_query("SELECT * FROM student_class where level!='COMPLETED' ")or die(mysql_query());
   $num_students = mysql_num_rows($check);
 
   //checking if the head entered all remarks for all students
//echo $rows1;echo $num_students; exit;
// CHECKING IF THERE ARE NO PENING CORRECTIONS
$pending=mysql_query("select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and status='pending' ") or die(mysql_error());	  
$rowpending = mysql_num_rows($pending); 

		  if($num_students==$rows1 && $rowpending==0){
if(isset($_POST['Publish'])){

mysql_query("UPDATE results set open='yes' where open='no'") or die (mysql_error()); 
   ?>
    <script language="javascript">
 alert("Results Published")
javascript:history.go(-1)
  </script>
  <?php
  }
  if(isset($_POST['Suppress'])){

mysql_query("UPDATE results set open='no' where open='yes'") or die (mysql_error()); 
   ?>
  <script language="javascript">
 alert("Results Suppressed")
javascript:history.go(-1)
  </script>
  <?php
  }
  ?>
  <form action="" method="post"><center>
  <table width="200" border="0"  align="center">  <br><h5>Every Students Progress report has been finalised you can now publish the reports</h5>

  <tr>
    <td><label><?php
	$rs=mysql_query("select * from results limit 1") or die(mysql_error());	  
while($row = mysql_fetch_array($rs)){
		$open = $row['open'];}
$disabled = "disabled='disabled'";
      if ($open=="no"){
              $disabled = "";
       }
echo "<input type='submit' name='Publish', value='Publish' " . $disabled . "/>";
 
?>
      
    </label></td>
    <td><label><?php
$disabled = "disabled='disabled'";
      if ($open=="yes"){
              $disabled = "";
       }
echo "<input type='submit' name='Suppress', value='Suppress' " . $disabled . "/>";
  
?>
   
    </label></td>
  </tr>
</table>
</form></center><hr><?php }?>
<center>
<?php $session = date('Y');
 $result1 = mysql_query("SELECT * FROM class,users,final where class.teacher=users.username and class.teacher=final.ecnumber and year='$_SESSION[year]' and term='$_SESSION[term]' order by level asc,name asc")or die(mysql_query());
 $rows = mysql_num_rows($result1);
	if($rows==0)
 {
 	echo("<h5><font color='#FF0000'><br><br><br><br><br>No Student Reports have finalized by respective class teachers<br><br><br><br><br> </font></h5>");  
			exit; 	  
 }?><h5>Please click on each class status to view students in each class</h5><table border="1"><tr bgcolor="#FFFFFF"><td><strong>Class</strong></td><td><strong>Surname Name </strong></td><td><strong>STATUS</strong></td></tr><?php
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
	   $status='Heads Remarks Captured';
	      }
 
		  else{
			   $status='Capturing Progress..........';
			  }
$level=$row1['level'];
 
$class=$row1['name'];
$surname=$row1['surname'];
$name=$row1['namee'];
$id=$row1['teacher'];

print "<tr><td>$level $class</td><td>$surname $name</td><td bgcolor='white'><a href='head.php?page=head_students.php&level=$level&class=$class&ec=$id&name=$name&surname=$surname 'target='_blank'>  $status</a></td></tr>

";

}
 ?>
</table>

<!--// find out hw many classes anodzidziswa to makesur all reports have been handed to the head-->
</body>
</html>