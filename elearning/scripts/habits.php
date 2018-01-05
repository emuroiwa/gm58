<?php
 
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='habits'  and session='$_SESSION[year]' and term='$_SESSION[term]'  ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
   //echo $rows;
   //exit;
  while($rwavg = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $art=$rwavg['mark'];
  } 
 // echo $rows;
	
 function get1($subject,$subjectyacho){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject='$subject' and subject_id='$subjectyacho' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$_GET[reg]' ")or die(mysql_query());
  
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $mechanical=$rw1['effort']; 
  return $mechanical;  }
  }
  	
  $directions=get1("Follows Directions","habits");
   $improve=get1("Strives to Improve","habits");
    $independent=get1("Works Independently","habits");
	 $time=get1("Makes good use of Time","habits");
	  $concentrate=get1("Ability to concentrate","habits"); 
	   $homework=get1("homework","habits");
	   
  if($rows>0){
	echo"<center><table border='1'  align='center'><tr bgcolor='#FFFFFF'><td><strong>Subject</strong></td><td><strong>Effort Captured</strong></td><td><strong>Click To Edit</strong></td></tr>";
function pano($sub,$variable,$subject){
	  $t = mysql_query("SELECT * FROM class ,final ,student_class WHERE class.teacher = final.ecnumber AND student_class.`level` = class.`level` AND class.`name` = student_class.class AND student_class.student = '$_GET[reg]' and final.term='$_SESSION[term]'and final.year='$_SESSION[year]' ")or die(mysql_query());
   $order = mysql_num_rows($t);	  
   //check if stuent needs corrections
    $corrections=mysql_query("select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]'  and status='pending'" );


 $correctionrows = mysql_num_rows($corrections);   if($order==11 && $correctionrows==0){
	  // $status='ORDER FINALIZED';
	   	$a= "<tr><td><strong>$sub</strong></td><td bgcolor='#FFFFFF'>$variable</td><td>ORDER FINALIZED</td></tr>";
	      } else{
	$a="<tr><td><strong>$sub</strong></td><td bgcolor='#FFFFFF'>$variable</td><td><a href='index.php?page=updateeffort2.php&name=$subject&subject=$sub&reg=$_GET[reg]&mark=$variable&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'>[ edit ]</a></td></tr>
		

";}
return $a;
}
echo pano("Follows Directions",$directions,"habits");
echo 	pano("Strives to Improve",$improve,"habits");
echo	pano("Works Independently",$independent,"habits");
echo	pano("Makes good use of Time",$time,"habits");
echo	pano("Ability to concentrate",$concentrate,"habits");
echo		pano("Homework",$homework,"habits");
require_once('social.php');	
	//echo "</table>";


	
  }

?>
