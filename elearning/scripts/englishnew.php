<?php $r1 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='English' and subject='spelling' and date='$datewritten' and term='$_SESSION[term]'and description='$description' ")or die(mysql_query());
   $row = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $spelling=$rw1['mark'];} //spellling
  
   $r12 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='English' and subject='Linguistics' and date='$datewritten' and term='$_SESSION[term]' and description='$description' ")or die(mysql_query());
   $rows1 = mysql_num_rows($r12);
 while($rw12 = mysql_fetch_array($r12, MYSQL_ASSOC)){
  $linguistics=$rw12['mark'];}//linguistics
  
    $r13 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='English' and subject='Writting' and date='$datewritten' and term='$_SESSION[term]' and description='$description' ")or die(mysql_query());
   $rows2 = mysql_num_rows($r13);
 while($rw13 = mysql_fetch_array($r13, MYSQL_ASSOC)){
  $writting=$rw13['mark'];}//writting
  
  $r14 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='English' and subject='Comprehension' and date='$datewritten' and term='$_SESSION[term]' and description='$description' ")or die(mysql_query());
   $rows3 = mysql_num_rows($r14);
 while($rw14 = mysql_fetch_array($r14, MYSQL_ASSOC)){
  $comprehension=$rw14['mark'];} 
  
   $r15 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='English' and subject='Creative' and date='$datewritten' and term='$_SESSION[term]' and description='$description'")or die(mysql_query());
   $rows4 = mysql_num_rows($r15);
 while($rw15 = mysql_fetch_array($r15, MYSQL_ASSOC)){
  $creative=$rw15['mark'];}
  
    $r16 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='English' and subject='Dictation' and date='$datewritten' and term='$_SESSION[term]' and description='$description' ")or die(mysql_query());
   $rows5 = mysql_num_rows($r16);
 while($rw16 = mysql_fetch_array($r16, MYSQL_ASSOC)){
  $dictation=$rw16['mark'];}
   $sum = mysql_query("SELECT Sum(cw.mark) AS sum FROM `cw` WHERE cw.reg = '$reg' AND
cw.subject_id = 'English' AND date='$datewritten' AND  cw.term = '$_SESSION[term]' and description='$description' ")or die(mysql_query());  
 while($rwsum = mysql_fetch_array($sum, MYSQL_ASSOC)){
  $tot=$rwsum['sum'];}
  $average=$tot/6;
   $result1 = mysql_query("SELECT * FROM subjects where type not in(select subject from cw where term='$_SESSION[term]' and date='$datewritten' and reg='$reg' and description='$description') and subject='english'  ")or die(mysql_query());
   $averagee=round($average, 2);
 echo"<strong>ENGLISH AVERAGE $averagee% FOR $name $surname ($reg)<hr> </strong>";
 $co=0;
 if($row==1){print "<a href='index.php?page=updatecw.php&name=Spelling&level=$_REQUEST[level]&subject=english&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$spelling'><br>
Captured $spelling %for spelling [ edit ]</a><br><br>

";}
if($rows1==1){print "<a href='index.php?page=updatecw.php&name=Linguistics&level=$_REQUEST[level]&subject=english&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$linguistics'>Captured $linguistics % for linguistics [ edit ]</a><br><br>

";}
if($rows2==1){print "<a href='index.php?page=updatecw.php&name=writting&level=$_REQUEST[level]&subject=english&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$writting'>Captured $writting % for writting [ edit ] </a><br><br>

";}
if($rows3==1){print "<a href='index.php?page=updatecw.php&name=Comprehension&level=$_REQUEST[level]&subject=english&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$comprehension'> Captured $comprehension % for Comprehension [ edit ] </a><br><br>

";}
if($rows4==1){print "<a href='index.php?page=updatecw.php&name=Creative&level=$_REQUEST[level]&subject=english&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$creative'> Captured $creative % for Creative [ edit ]</a><br><br>

";}																				
if($rows5==1){print "<a href='index.php?page=updatecw.php&name=Dictation&level=$_REQUEST[level]&subject=english&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$dictation'> Captured $dictation % for Dictation [ edit ] </a><br><br>

";}
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)){
$co++;
$subject=$row1['type'];

if($row==0 or $rows1==0 or $rows2==0 or $rows3==0 or $rows4==0 or $rows5==0 ) {
print "<a href='index.php?page=cw.php&name=$subject&subject=english&reg=$reg&date=$_REQUEST[date]&de=$_REQUEST[de]'><p align='left'>$co) $subject</a></p>
";}
} ?>