<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<center><?php 
// if order has been finalised
   $t = mysql_query("SELECT * FROM final where  year='$_SESSION[year]' and term='$_SESSION[term]' and ecnumber='$_SESSION[username]'  ")or die(mysql_query());
   $order = mysql_num_rows($t);
  if($order==0)
echo '<table border="1"><tr bgcolor="#FFFFFF"><td><strong>Student Number</strong></td><td><strong>Surname Name</strong></td><td><strong>STATUS</strong></td></tr>'; 
  else
echo '<table border="1"><tr bgcolor="#FFFFFF"><td><strong>Student Number</strong></td><td><strong>Surname Name</strong></td><td><strong>Overall Average</strong></td><td><strong>Position</strong></td><td><strong>STATUS</strong></td></tr>'; 
echo "
Please click <strong>Student Status</strong> to enter each student <strong>Remarks</strong><br>For term $_SESSION[term] year $_SESSION[year]<br>"; ?>
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
 $result1 = mysql_query("SELECT * FROM student_class,student where student_class.level='$grd' and student_class.student=student.reg and class='$class' and status='ENROLLED' order by sex asc, surname asc")or die(mysql_query());
 $students = mysql_num_rows($result1);
	if($students==0)
 {
 	echo("<font color='red'>No students taking this subject please contact the adminstrator now</font>");  
			exit; 	  
 }
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))
{
	
	 $r1 = mysql_query("SELECT * FROM results where  session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$row1[student]' ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
   //checking if results have been published
     $rrrr = mysql_query("SELECT * FROM results where  session='$_SESSION[year]' and term='$_SESSION[term]' and open='yes' ")or die(mysql_query());
   //$rows = mysql_num_rows($r1); 


//checking if each student has been finalised
   $r12 = mysql_query("SELECT * FROM remarks where  session='$_SESSION[year]' and term='$_SESSION[term]'  and subject_id='overall' ")or die(mysql_query());
   $rows1 = mysql_num_rows($r12);
  // echo $rows1; exit;

    $r121 = mysql_query("SELECT * FROM remarks where  session='$_SESSION[year]' and term='$_SESSION[term]'  and student='$row1[student]' ")or die(mysql_query());
   $rows111 = mysql_num_rows($r121);
  // echo $rows111;
$left=8-$rows111;
   
if($rows111<8){
	   $status="<font color='orange'>$left Remarks to be captured...</font>";
	      } 		 
		  else{
			   $status="<font color='green'>All remarks captured</font>";
			  } 

 $reg=$row1['student'];
$name=$row1['name'];
$surname=$row1['surname'];
$level=$row1['level'];
$id=$row1['id'];
if(mysql_num_rows($rrrr)==0){
	
	if($order==1){
				 
 $resultzz = mysql_query("SELECT * FROM student_class,student where student_class.level='$grd' and student_class.student=student.reg and class='$class'")or die(mysql_query());
 
    $corder = mysql_query("SELECT * FROM remarks where  session='$_SESSION[year]' and term='$_SESSION[term]'  and student='$row1[student]' and subject_id='head' ")or die(mysql_query());
  // echo $rows111;

   
if( mysql_num_rows($corder)==0){
	   $status="<font color='red'>Heads Remarks Not Captured</font>";
	      } 		 
		  else{
			   $status="<font color='green'>All remarks captured</font>";
			  } 
//position if order finalised
mysql_query("SET @row=0");
$pos=mysql_query("SELECT student,pos,average FROM (SELECT @row := @row+1 AS pos,student,average FROM average  where
 session='$_SESSION[year]' and `term`='$_SESSION[term]'  and subject_id = 'OVERALL' and grade = '$level' and class = '$class' ORDER BY average DESC) as n where student='$row1[student]' ORDER BY student DESc ");
  while($rowpos = mysql_fetch_array($pos, MYSQL_ASSOC)){
  $position=$rowpos['pos'];
  $reg=$rowpos['student'];
  $avg=$rowpos['average'];}
//////////////////////////////////////////////////////////////////
	   print "<tr><td>$reg</td><td>$surname $name</td><td>$avg</td><td>$position</td><td bgcolor='white'><a href='index.php?page=tab.php&level=$level&reg=$reg&name=$name&surname=$surname 'target='_blank'> $status</a></td></tr>";
	      }
	
else{	
print "<tr><td>$reg</td><td>$surname $name</td><td bgcolor='white'><a href='index.php?page=tab.php&level=$level&reg=$reg&name=$name&surname=$surname 'target='_blank'>  $status</a></td></tr>";}
} if($order==1 && mysql_num_rows($rrrr)>0){
	//position if results publised
	mysql_query("SET @row=0");
$pos=mysql_query("SELECT student,pos,average FROM (SELECT @row := @row+1 AS pos,student,average FROM average  where
 session='$_SESSION[year]' and `term`='$_SESSION[term]'  and subject_id = 'OVERALL' and grade = '$level' and class = '$class' ORDER BY average DESC) as n where student='$row1[student]' ORDER BY student DESc ");
  while($rowpos = mysql_fetch_array($pos, MYSQL_ASSOC)){
  $position=$rowpos['pos'];
  $reg=$rowpos['student'];
  $avg=$rowpos['average'];}
  //////////////////////////////////////////////////////
	print "<tr><td>$reg</td><td>$surname $name</td><td>$avg</td><td>$position</td><td bgcolor='white'><a href='print/printstd1.php?reg=$reg&name=$name&surname=$surname 'target='_blank'>  VIEW REPORT</a></td></tr>";
	}
}
//echo "</table>";
//echo $rows111;  echo $students; exit;
 $r121w = mysql_query("SELECT * FROM remarks where  session='$_SESSION[year]' and term='$_SESSION[term]'  and teacher='$_SESSION[username]'  and subject_id='overall' ")or die(mysql_query());
   $rows111w = mysql_num_rows($r121w);
   
if($students==$rows111w){
	if(isset($_POST['Publish'])){
		$time=date('m/d/Y-h:m:s');
		
		$sq="select * from final where session='$_SESSION[year]' and term='$_SESSION[term]' and ecnumber='$_SESSION[username]' ";
$rem=mysql_query($sq);
 $remarkrows = mysql_num_rows($rem);
if ($remarkrows==1){?>
<script language="javascript">
 alert("ORDER FINALIZED")

  </script>
<?php  exit;
}
 mysql_query("INSERT INTO final (ecnumber,year,term,date)
VALUES
('$_SESSION[username]','$_SESSION[year]','$_SESSION[term]','$time') ") or die (mysql_error()); 
?>
<script language="javascript">

  
  location = 'index.php?page=students.php'  
  </script><?php
   header("location: index.php?page=students.php"); 
  }?>

	<form action="" method="post">
  <br>
  <table width="200" border="0"  align="center">
  <tr>
    <td><label><?php
	//checking penging corrections
	 $rs13=mysql_query("select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and status='pending' and ecnumber='$_SESSION[username]'") or die(mysql_error());	  
$rowss1 = mysql_num_rows($rs13);
	$rs1=mysql_query("select * from final where year='$_SESSION[year]' and term='$_SESSION[term]' and ecnumber='$_SESSION[username]' ") or die(mysql_error());	  
$rowzz = mysql_num_rows($rs1);
if ($rowzz==1){
$disabled = "disabled='disabled'";
 $title="ORDER FINALIZED  FOR Year $_SESSION[year] term $_SESSION[term]";}
      else{
              $disabled = "";
			  $title="FINALISE ORDER  FOR Year $_SESSION[year] Term $_SESSION[term]";
       }if(mysql_num_rows($rrrr)>0){$title="                  RESULTS HAVE BEEN PUBLISHED                   ";}
echo "<input type='submit' name='Publish', value='                         $title                        ' " . $disabled . "/>";
 
?>
      
    </label></td>
    

</form>
	
	<?php }
}
?></table>
</body>
</html>