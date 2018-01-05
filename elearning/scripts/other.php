<?php
//end of class averaage ----------------------------------------------------------------------------------------------------
function classavgshona($x)
{
	 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
 $aanum = mysql_query("SELECT * FROM results where subject_id='other' and subject='$x' and session='$_SESSION[year]' and term='$_SESSION[term]' and class='$class' and level='$grd'  ")or die(mysql_query());
  $rowsaa = mysql_num_rows($aanum);
  
   $aa = mysql_query("SELECT Sum(results.mark) as n FROM results where subject_id='other' and subject='$x' and session='$_SESSION[year]' and term='$_SESSION[term]' and class='$class' and level='$grd'  ")or die(mysql_query());
 while($aarw = mysql_fetch_array($aa, MYSQL_ASSOC)){
  $mechanicalavg=$aarw['n'];}
  $mechanical_classavg=$mechanicalavg/$rowsaa;
  $mechanical_classavg_rounded=round($mechanical_classavg, 2);
return  $mechanical_classavg_rounded;
}
$mechanicalavg=classavgshona("shona");

$classshona=round($mechanicalavg,2);
//end of class averaage ----------------------------------------------------------------------------------------------------
function remarks($subject){
	$sq="select * from remarks where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]' and subject_id='$subject'";
$rem=mysql_query($sq);
 $remarkrows = mysql_num_rows($rem);
if ($remarkrows==1){
while($row233=mysql_fetch_array($rem,MYSQL_ASSOC)){
	$remark=$row233['remark'];
	return $remark;
	}	}}
	$shonaremark=remarks("shona");
	$Art_Craft_remark=remarks("Art_Craft");
	$Extra_Mural_Actvites_remark=remarks("Extra_Mural_Actvites");
	$computers_remark=remarks("computers");
//GETTING STREAM AVERAGE PER SUBJECT IN SUBJECT_ID MATHS

function streamavgshona($y)
{
	 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
 $aanum = mysql_query("SELECT * FROM results where subject_id='other' and subject='$y' and session='$_SESSION[year]' and term='$_SESSION[term]'  and level='$grd'  ")or die(mysql_query());
  $rowsaa = mysql_num_rows($aanum);
  
   $aa = mysql_query("SELECT Sum(results.mark) as n FROM results where subject_id='other' and subject='$y' and session='$_SESSION[year]' and term='$_SESSION[term]'  and level='$grd'  ")or die(mysql_query());
 while($aarw = mysql_fetch_array($aa, MYSQL_ASSOC)){
  $stravg=$aarw['n'];}
  $all_stravg=$stravg/$rowsaa;
  $all_stravg_rounded=round($all_stravg, 2);
return  $all_stravg_rounded;
}
$mechanical_stream_avg=streamavgshona("shona");

$streamshona=round($mechanical_stream_avg, 2);

// end of average-----------------------------------------------------------------------------------------------------
//get student position-----------------------------------------------------------------------------my best query eva yakaipa
mysql_query("SET @row=0");
$pos=mysql_query("SELECT student,pos,average FROM (SELECT @row := @row+1 AS pos,student,average FROM average  where
 session='$_SESSION[year]' and `term`='$_SESSION[term]'  and subject_id = 'shona' ORDER BY average DESC) as n WHERE student='$reg'");
  while($rowpos = mysql_fetch_array($pos, MYSQL_ASSOC)){
  $position=$rowpos['pos'];
  } 

//getting other marks from table--------------------------------------------------------------------------------------------
  function mark($subjectyacho){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='other' and subject='$subjectyacho' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$_GET[reg]' ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $shona=$rw1['mark'];} 
  return $shona;  
  }
  $shona=mark("shona");
   $computers=mark("computers");
    $Art_Craft=mark("Art_Craft");
$Extra_Mural_Actvites=mark("Extra_Mural_Actvites");

	  //getting marks number of rows----------------------------------------------------------------------------------
    function markrows($subjectyacho){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='other' and subject='$subjectyacho' and session='$_SESSION[year]' and term='$_SESSION[term]'  ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
  return $rows;  
  }
      function markrow(){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='other'  and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$_GET[reg]' ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
  return $rows;  
  }
	  //end of getting marks number of rows----------------------------------------------------------------------------------
   $result1 = mysql_query("SELECT * FROM subjects where type not in(select subject from results where term='$_SESSION[term]' and session='$_SESSION[year]' and reg='$reg' and subject_id='shona') and subject='other' and type='shona' ")or die(mysql_query());
   $averagee=round($shona, 2);
   
    
   
   $avgcheck = mysql_query("SELECT * FROM average where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg' and subject_id = 'shona' ")or die(mysql_query());
   $avgnum = mysql_num_rows($avgcheck);
 while($rwavg = mysql_fetch_array($avgcheck, MYSQL_ASSOC)){
  $avgintable=$rwavg['average'];
  } if($avgnum==1){
	mysql_query("update average set average='$averagee' where
 session='$_SESSION[year]' and `term`='$_SESSION[term]' and student='$reg' and subject_id = 'shona'") or die (mysql_error());  
	  
  }if($avgnum==0){
	  
mysql_query("INSERT INTO average (student,subject_id,class,grade,average,session,term)
VALUES
('$reg','shona','$class','$grd','$averagee','$_SESSION[year]','$_SESSION[term]')") or die (mysql_error());
	  }
//get student position-----------------------------------------------------------------------------my best query eva yakaipa
mysql_query("SET @row=0");
$pos=mysql_query("SELECT student,pos,average FROM (SELECT @row := @row+1 AS pos,student,average FROM average  where
 session='$_SESSION[year]' and `term`='$_SESSION[term]'  and subject_id = 'shona' and grade = '$grd' and class = '$class' ORDER BY average DESC) as n WHERE student='$reg'");
  while($rowpos = mysql_fetch_array($pos, MYSQL_ASSOC)){
  $position=$rowpos['pos'];
  } 
    if($averagee==100){$position=1;}
 
 //end of yakaipa-------------------------------------------------------------------------------------------------------  
echo"<center>Students Average $averagee% Position For Shona is <strong>$position</strong> </center> <hr>";
 //capture marks--------------------------------------------------------------------------------------------------------
 $co=0;
  while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)){
$co++;
$subject=$row1['type'];

if(markrows("shona")==0) {
print "<a href='index.php?page=shonaresult.php&name=$subject&subject=other&reg=$reg&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'><p align='left'>$co) <strong>$subject</strong></a></p>
";}
}   $result12 = mysql_query("SELECT * FROM subjects where type not in(select subject from results where term='$_SESSION[term]' and session='$_SESSION[year]' and reg='$reg' and subject_id='other') and subject='other' and type!='shona'")or die(mysql_query());


  while($row12 = mysql_fetch_array($result12, MYSQL_ASSOC)){
$co++;
$subject=$row12['type'];

if(markrows("computers")==0 or markrows("Art_Craft")==0 or markrows("Extra_Mural_Actvites")==0 ) {
print "<a href='index.php?page=otherresult.php&name=$subject&subject=other&reg=$reg&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'><p align='left'>$co) <strong>$subject</strong></a></p>
";}
}

 // interface for updating the caputuerd marks------------------------------------------------------------------------------
  $t = mysql_query("SELECT * FROM class ,final ,student_class WHERE class.teacher = final.ecnumber AND student_class.`level` = class.`level` AND class.`name` = student_class.class AND student_class.student = '$_GET[reg]' and final.term='$_SESSION[term]'and final.year='$_SESSION[year]' ")or die(mysql_query());
   $order = mysql_num_rows($t); //check if stuent needs corrections
   $corrections=mysql_query("select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]'  and status='pending'" );


 $correctionrows = mysql_num_rows($corrections);	   if($order==1 && $correctionrows==0){
	  // $status='ORDER FINALIZED';
	   	$a= "<tr><td><strong>Shona</strong></td><td bgcolor='#FFFFFF'>$shona%</td><td>$classshona%</td><td>$streamshona%</td><td>$shonaremark<br>
<a href='index.php?page=updateshona.php&name=shona&subject=shona&reg=$reg&mark=$shona&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&remark=$shonaremark'>[ Edit Remark  ]</a></td></tr>";
	   	$b= "<tr><td><strong>Computers</strong></td><td bgcolor='#FFFFFF'>$computers</td><td>--</td><td>--</td><td>$computers_remark<br>
 <a href='index.php?page=updateother.php&name=computers&subject=other&reg=$reg&mark=$computers&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&remark=$computers_remark'>[ Edit Remark  ]</a></td></tr>";
			   	$c= "<tr><td><strong>Art_Craft</strong></td><td bgcolor='#FFFFFF'>$Art_Craft</td><td>--</td><td>--</td><td>$Art_Craft_remark <br>
<a href='index.php?page=updateother.php&name=Art_Craft&subject=other&reg=$reg&mark=$Art_Craft&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&remark=$Art_Craft_remark'>[ Edit Remark  ]</a></td></tr>";	   	
				$d= "<tr><td><strong>Extra_Mural_Actvites</strong></td><td bgcolor='#FFFFFF'>$Extra_Mural_Actvites</td><td>--</td><td>--</td><td>$Extra_Mural_Actvites_remark<br>
 <a href='index.php?page=updateother.php&name=Extra_Mural_Actvites&subject=other&reg=$reg&mark=$Extra_Mural_Actvites&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&remark=$Extra_Mural_Actvites_remark'><br>
[ Edit Remark ]</a></td></tr>";


	      } else{
	$a= "<tr><td><strong>Shona</strong></td><td bgcolor='#FFFFFF'>$shona%</td><td>$classshona%</td><td>$streamshona%</td><td>$shonaremark<br><a href='index.php?page=updateshona.php&name=shona&subject=shona&reg=$reg&mark=$shona&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&remark=$shonaremark'>[ Add Remark  ]</a></td></tr>

";
$b="<tr><td><strong>Computers</strong></td><td bgcolor='#FFFFFF'>$computers</td><td>--</td><td>--</td><td>$computers_remark<br><a href='index.php?page=updateother.php&name=computers&subject=other&reg=$reg&mark=$computers&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&remark=$computers_remark'>[ Add Remark  ]</a></td></tr>
";
$c="<tr><td><strong>Art/Craft</strong></td><td bgcolor='#FFFFFF'>$Art_Craft</td><td>--</td><td>--</td><td>$Art_Craft_remark <br><a href='index.php?page=updateother.php&name=Art_Craft&subject=other&reg=$reg&mark=$Art_Craft&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&remark=$Art_Craft_remark'>[ Add Remark  ]</a></td></tr>

";
$d="<tr><td><strong>Extra_Mural_Actvites</strong></td><td bgcolor='#FFFFFF'>--</td><td>--</td><td>--</td><td>$Extra_Mural_Actvites_remark<br><a href='index.php?page=updateother.php&name=Extra_Mural_Actvites&subject=other&reg=$reg&mark=$Extra_Mural_Actvites&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&remark=$Extra_Mural_Actvites_remark'>[ Add Remark ]</a></td></tr>

";

}
if(markrow()>0){
	echo"<center><table border='1'  align='center'><tr bgcolor='#FFFFFF'><td><strong>Subject</strong></td><td><strong>Mark Captured</strong></td><td><strong>Class Average</strong></td><td><strong>Stream Average</strong></td><td width='50%'><strong>Click To Edit</strong></td><tr>";
 if(markrows("shona")==1){print "$a
";}
	 if(markrows("computers")==1){print "$b
";}
 if(markrows("Art_Craft")==1){print "$c$d
";} if(markrows("Extra_Mural_Actvites")==1){print "$d
";}

echo"</table>";

//REMARKS html form and php mysql script-------------------------------------------------------------------------------------



}

//END of REMARKS----------------------------------------------------------------------------------------------------------


?></center>

 