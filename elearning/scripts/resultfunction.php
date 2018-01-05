<?php 
  
 function subjectresult($subject_id,$subject,$year,$term){
  
  $mark= mysql_query("SELECT * FROM results ,student ,student_class WHERE results.reg = student.reg AND results.term ='$term' AND results.session ='$year' AND results.reg = '$_GET[reg]'   AND student.reg = student_class.student and subject_id='$subject_id' and subject='$subject'  ")or die(mysql_query());
 
	while($row1 = mysql_fetch_array($mark, MYSQL_ASSOC))
	  	  {$marksnow =$row1['mark'];
		 
	 return $marksnow; }

}

function subjecteffort($subject_id,$subject,$year,$term){
  
  $mark = mysql_query("SELECT * FROM results ,student ,student_class WHERE results.reg = student.reg AND results.term ='$term' AND results.session ='$year' AND results.reg = '$_GET[reg]'   AND student.reg = student_class.student and subject_id='$subject_id' and subject='$subject' order by subject desc ")or die(mysql_query());
 
	while($row1 = mysql_fetch_array($mark, MYSQL_ASSOC))
	  	  {$marksnow =$row1['effort'];
		 
	 return $marksnow; }
}
//form function  calling

		  
		  
		  
		  
		  
 function classavg($subject_id,$subject,$year,$term)
{
	 $rs1=mysql_query("select * from student_class where student='$_GET[reg]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['class'];}
 $aanum = mysql_query("SELECT * FROM results where subject_id='$subject_id' and subject='$subject' and session='$year' and term='$term' and class='$class' and level='$grd'")or die(mysql_query());
  $rowsaa = mysql_num_rows($aanum);
  
   $aa = mysql_query("SELECT Sum(results.mark) as n FROM results where subject_id='$subject_id' and subject='$subject' and session='$year' and term='$term' and class='$class' and level='$grd'   ")or die(mysql_query());
 while($aarw = mysql_fetch_array($aa, MYSQL_ASSOC)){
  $spellingavg=$aarw['n'];}
  $spelling_classavg=$spellingavg/$rowsaa;
  $spelling_classavg_rounded=round($spelling_classavg, 2);
return $spelling_classavg_rounded;
}


function streamavg($subject_id,$subject,$year,$term)
{
	 $rs1=mysql_query("select * from student_class where student='$_GET[reg]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['class'];}
 $aanum = mysql_query("SELECT * FROM results where subject_id='$subject_id' and subject='$subject' and session='$year' and term='$term'  and level='$grd' ")or die(mysql_query());
  $rowsaa = mysql_num_rows($aanum);
  
   $aa = mysql_query("SELECT Sum(results.mark) as n FROM results where subject_id='$subject_id' and subject='$subject' and session='$year' and term='$term'  and level='$grd'  ")or die(mysql_query());
 while($aarw = mysql_fetch_array($aa, MYSQL_ASSOC)){
  $stravg=$aarw['n'];}
  $all_stravg=$stravg/$rowsaa;
  $all_stravg_rounded=round($all_stravg, 2);
return  $all_stravg_rounded;
}
		  
		  
	
function remarks($subject_id,$year,$term)
{

$rs1=mysql_query("select * from remarks where student='$_GET[reg]' and session='$year' and term='$term' and subject_id='$subject_id' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$remark= $row1['remark'];
		}
return  $remark;
}

function overall($subject_id,$year,$term)
{

$rs1=mysql_query("select * from average where student='$_GET[reg]' and session='$year' and term='$term' and subject_id='$subject_id' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$remark= $row1['average'];
		}
return  $remark;
}
function studentavg($subject_id,$year,$term){
 $avgcheck = mysql_query("SELECT * FROM average where session='$year' and term='$term' and student='$_GET[reg]' and subject_id = '$subject_id' ")or die(mysql_query());
   $avgnum = mysql_num_rows($avgcheck);
 while($rwavg = mysql_fetch_array($avgcheck, MYSQL_ASSOC)){
  $avgintable=$rwavg['average'];}
  return $avgintable;
  }
  
  function shona(){
 $avgcheck = mysql_query("SELECT * FROM student_class where  student='$_GET[reg]'  ")or die(mysql_query());
   $avgnum = mysql_num_rows($avgcheck);
 while($rwavg = mysql_fetch_array($avgcheck, MYSQL_ASSOC)){
  $avgintable=$rwavg['shona'];}
  return $avgintable;
  }
?>
