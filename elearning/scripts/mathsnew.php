<?php $r1 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='maths' and subject='mechanical' and date='$datewritten' and term='$_SESSION[term]' and description='$description'  ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $mechanical=$rw1['mark'];} 
  
   $r12 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='maths' and subject='mental' and date='$datewritten' and term='$_SESSION[term]' and description='$description' ")or die(mysql_query());
   $rows1 = mysql_num_rows($r12);
 while($rw12 = mysql_fetch_array($r12, MYSQL_ASSOC)){
  $mental=$rw12['mark'];}
  
    $r13 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='maths' and subject='problems' and date='$datewritten' and term='$_SESSION[term]' and description='$description' ")or die(mysql_query());
   $rows2 = mysql_num_rows($r13);
 while($rw13 = mysql_fetch_array($r13, MYSQL_ASSOC)){
  $problem=$rw13['mark'];}
  
      $sum = mysql_query("SELECT Sum(cw.mark) AS sum FROM `cw` WHERE cw.reg = '$reg' AND
cw.subject_id = 'maths' AND date='$datewritten' AND  cw.term = '$_SESSION[term]' and description='$description' ")or die(mysql_query());  
 while($rwsum = mysql_fetch_array($sum, MYSQL_ASSOC)){
  $tot=$rwsum['sum'];}
  $average=$tot/3;
  
   $result1 = mysql_query("SELECT * FROM subjects where type not in(select subject from cw where term='$_SESSION[term]' and date='$datewritten' and reg='$reg' and description='$description' ) and subject='maths' ")or die(mysql_query());
   $averagee=round($average, 2);
   
   //average
   
   $avgcheck = mysql_query("SELECT * FROM average where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg' and subject_id = 'maths' ")or die(mysql_query());
   $avgnum = mysql_num_rows($avgcheck);
 while($rwavg = mysql_fetch_array($avgcheck, MYSQL_ASSOC)){
  $avgintable=$rwavg['average'];
  } if($avgnum==1){
	mysql_query("update average set average='$averagee' where
 session='$_SESSION[year]' and `term`='$_SESSION[term]' and student='$reg' and subject_id = 'maths'") or die (mysql_error());  
	  
  }if($avgnum==0){
	  
mysql_query("INSERT INTO average (student,subject_id,class,grade,average,session,term)
VALUES
('$reg','maths','$class','$grd','$averagee','$_SESSION[year]','$_SESSION[term]')") or die (mysql_error());
	  }
  
  
 echo"<strong>MATHS AVERAGE $averagee% FOR $name $surname ($reg)<hr></strong>";
 $co=0;
 if($rows==1){print "<a href='index.php?page=updatecw.php&name=mechanical&level=$_REQUEST[level]&subject=maths&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$mechanical'><br>
Captured $mechanical %for mechanical [ edit ]</a><br><br>

";}
if($rows1==1){print "<a href='index.php?page=updatecw.php&name=mental&level=$_REQUEST[level]&subject=maths&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$mental'>Captured $mental % for mental [ edit ]</a><br><br>

";}
if($rows2==1){print "<a href='index.php?page=updatecw.php&name=problem&level=$_REQUEST[level]&subject=maths&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$problem&surname=$_REQUEST[surname]&name=$_REQUEST[name]'> Captured $problem % for problems [ edit ] </a><br>
";}
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)){
$co++;
$subject=$row1['type'];

if($rows==0 or $rows1==0 or $rows2==0) {
print "<a href='index.php?page=cw.php&name=$subject&level=$_REQUEST[level]&subject=maths&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&surname=$_REQUEST[surname]&name=$_REQUEST[name]'><p align='left'>$co) $subject</a></p>
";}
} ?>