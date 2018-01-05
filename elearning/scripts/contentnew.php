  <?php 
 //content

  $r1 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='content' and subject='Agriculture' and date='$datewritten' and term='$_SESSION[term]' and description='$description' ")or die(mysql_query());
   $row = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $agriculture=$rw1['mark'];} //spellling
  
   $r12 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='content' and subject='Home Economics' and date='$datewritten' and term='$_SESSION[term]' and description='$description' ")or die(mysql_query());
   $rows1 = mysql_num_rows($r12);
 while($rw12 = mysql_fetch_array($r12, MYSQL_ASSOC)){
  $home=$rw12['mark'];}//linguistics
  
    $r13 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='content' and subject='Shona' and date='$datewritten' and term='$_SESSION[term]'and description='$description' ")or die(mysql_query());
   $rows2 = mysql_num_rows($r13);
 while($rw13 = mysql_fetch_array($r13, MYSQL_ASSOC)){
  $shona=$rw13['mark'];}//writting
  
  $r14 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='content' and subject='Computers' and date='$datewritten' and term='$_SESSION[term]' and description='$description' ")or die(mysql_query());
   $rows3 = mysql_num_rows($r14);
 while($rw14 = mysql_fetch_array($r14, MYSQL_ASSOC)){
  $computers=$rw14['mark'];} 
  
   $r15 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='content' and subject='Scripture' and date='$datewritten' and term='$_SESSION[term]' and description='$description' ")or die(mysql_query());
   $rows4 = mysql_num_rows($r15);
 while($rw15 = mysql_fetch_array($r15, MYSQL_ASSOC)){
  $scripture=$rw15['mark'];}
  
    $r16 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='content' and subject='Science' and date='$datewritten' and term='$_SESSION[term]' and reg='$reg' and description='$description'")or die(mysql_query());
   $rows5 = mysql_num_rows($r16);
 while($rw16 = mysql_fetch_array($r16, MYSQL_ASSOC)){
  $science=$rw16['mark'];}
  
  $r17 = mysql_query("SELECT * FROM cw where reg='$reg' and subject_id='content' and subject='Social Studies' and date='$datewritten' and term='$_SESSION[term]' and reg='$reg' and description='$description' ")or die(mysql_query());
   $rows6= mysql_num_rows($r17);
 while($rw17 = mysql_fetch_array($r17, MYSQL_ASSOC)){
  $ss=$rw17['mark'];}
   $sum = mysql_query("SELECT Sum(cw.mark) AS sum FROM `cw` WHERE cw.reg = '$reg' AND
cw.subject_id = 'content' AND date='$datewritten' AND  cw.term = '$_SESSION[term]' and description='$description' ")or die(mysql_query());  
 while($rwsum = mysql_fetch_array($sum, MYSQL_ASSOC)){
  $tot=$rwsum['sum'];}
  $average=$tot/7;
   $result1 = mysql_query("SELECT * FROM subjects where type not in(select subject from cw where term='$_SESSION[term]' and date='$datewritten' and reg='$reg' and description='$description') and subject='content' ")or die(mysql_query());
   $averagee=round($average, 2);
 echo"<strong>CONTENT AVERAGE $averagee% FOR $name $surname ($reg)<hr></strong><br>
";
 $co=0;
 if($row==1){print "<a href='index.php?page=updatecw.php&name=Agriculture&level=$_REQUEST[level]&subject=content&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$agriculture'>
Captured $agriculture %for Agriculture [ edit ]</a><br><br>

";}
if($rows1==1){print "<a href='index.php?page=updatecw.php&name=Home Economics&level=$_REQUEST[level]&subject=content&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$home'> Captured $home % for Home Economics [ edit ]</a><br><br>

";}
if($rows2==1){print "<a href='index.php?page=updatecw.php&name=Shona&level=$_REQUEST[level]&subject=content&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$shona'>Captured $shona % for Shona [ edit ] </a><br><br>

";}
if($rows3==1){print "<a href='index.php?page=updatecw.php&name=Computers&level=$_REQUEST[level]&subject=content&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$computers'> Captured $computers % for Computers [ edit ] </a><br><br>

";}
if($rows4==1){print "<a href='index.php?page=updatecw.php&name=Scripture&level=$_REQUEST[level]&subject=content&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$scripture'> Captured $scripture % for Scripture [ edit ]</a><br><br>

";}
if($rows5==1){print "<a href='index.php?page=updatecw.php&name=Science&level=$_REQUEST[level]&subject=content&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$science'> Captured $science % for Science [ edit ] </a><br><br>

";}
if($rows6==1){print "<a href='index.php?page=updatecw.php&name=Social Studies&level=$_REQUEST[level]&subject=content&reg=$reg&de=$_REQUEST[de]&date=$_REQUEST[date]&mark=$ss'> Captured $ss % for Social Studies [ edit ] </a><br><br>

";}
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)){
$co++;
$subject=$row1['type'];

if($row==0 or $rows1==0 or $rows2==0 or $rows3==0 or $rows4==0 or $rows6==0 or $rows5==0) {
print "<a href='index.php?page=cw.php&name=$subject&subject=content&reg=$reg&date=$_REQUEST[date]&de=$_REQUEST[de]'><p align='left'>$co) $subject</a></p>
";}
}
 ?>