<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<center><?php
$date = date('m/d/Y');
 $reg=$_GET['reg'];
$name=$_GET['name'];$surname=$_GET['surname'];
if(isset($_POST['submit'])){
$fn = time().$_FILES['file']['name'];
		  	if(!move_uploaded_file($_FILES['file']['tmp_name'],"report/".$fn)){?>
        <script language="javascript">
		alert("report uploaded");
		
		</script>
        <?php
		exit;}
  
   else{
			
	mysql_query("INSERT INTO reports (reg,report,session,term,date)
VALUES
('$reg','$fn','$_SESSION[year]','$_SESSION[term]','$date')") or die (mysql_error());
   }}

 echo "UPDATE RESULTS FOR $surname $name 
<br>
For term $_SESSION[term]  $_SESSION[year]<br>
Please click subject to update <br>
 <br>
"; 
  $r121 = mysql_query("SELECT * FROM results where  session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' and reg not in(select reg from reports where term='$_SESSION[term]' and session='$_SESSION[year]' and reg='$reg') ")or die(mysql_query());
   $rows11 = mysql_num_rows($r121);
 if($rows11==16){?>
<div id="b"><form action="" method="post"  enctype="multipart/form-data" name="addroom"  >
<table>
 <tr>
       <td><span class="style12">Upload Report (excel docu)</span></td>
       <td><input type="file" name="file" class="ed" id="file">
          </td>
            </tr> <tr><td  align="center"><input class="mybutton" type="submit" value="Submit" id="button" name="submit"></td></tr></table></div>
<?php }
$sq="select * from reports where  session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg'";
$re=mysql_query($sq);

while($row2=mysql_fetch_array($re,MYSQL_ASSOC)){
	echo
 "<table border='1'><tr><td>Report Card<br />
</td><td>Delete<br />
</td></tr>";
		$r = $row2['reg'];
		$id= $row2['id'];
echo
 "
 <tr><td>$r</td><td><a href='index.php?page=delete.php&id=$id'>
<font  color='#FF0000'>Delete </font></a></td></tr></table>";
}
?><?php
//maths
  $r1 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='maths' and subject='mechanical' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $mechanical=$rw1['mark'];} 
  
   $r12 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='maths' and subject='mental' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows1 = mysql_num_rows($r12);
 while($rw12 = mysql_fetch_array($r12, MYSQL_ASSOC)){
  $mental=$rw12['mark'];}
  
    $r13 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='maths' and subject='problems' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows2 = mysql_num_rows($r13);
 while($rw13 = mysql_fetch_array($r13, MYSQL_ASSOC)){
  $problem=$rw13['mark'];}
  
      $sum = mysql_query("SELECT Sum(results.mark) AS sum FROM `results` WHERE results.reg = '$reg' AND
results.subject_id = 'maths' AND results.`session` = '$_SESSION[year]' AND  results.term = '$_SESSION[term]' ")or die(mysql_query());  
 while($rwsum = mysql_fetch_array($sum, MYSQL_ASSOC)){
  $tot=$rwsum['sum'];}
  $average=$tot/3;
  
   $result1 = mysql_query("SELECT * FROM subjects where type not in(select subject from results where term='$_SESSION[term]' and session='$_SESSION[year]' and reg='$reg') and subject='maths' ")or die(mysql_query());
   $averagee=round($average, 2);
 echo"<strong><hr><hr>MATHS AVERAGE $averagee% </strong>";
 $co=0;
 if($rows==1){print "<a href='index.php?page=updateresults.php&name=mechanical&subject=maths&reg=$reg&mark=$mechanical'><br>
Captured $mechanical% for mechanical [ edit ]</a><br><br>

";}
if($rows1==1){print "<a href='index.php?page=updateresults.php&name=mental&subject=maths&reg=$reg&mark=$mental'>Captured $mental% for mental [ edit ]</a><br><br>

";}
if($rows2==1){print "<a href='index.php?page=updateresults.php&name=problems&subject=maths&reg=$reg&mark=$problem'> Captured $problem% for problems [ edit ] </a><br>
";}
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)){
$co++;
$subject=$row1['type'];

if($rows==0 or $rows1==0 or $rows2==0) {
print "<a href='index.php?page=results.php&name=$subject&subject=maths&reg=$reg'><p align='left'>$co) $subject</a></p>
";}
}
 ?>
 
 
 <?php 
 //engllish
  $r1 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='english' and subject='spelling' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $row = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $spelling=$rw1['mark'];} //spellling
  
   $r12 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='english' and subject='Linguistics' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows1 = mysql_num_rows($r12);
 while($rw12 = mysql_fetch_array($r12, MYSQL_ASSOC)){
  $linguistics=$rw12['mark'];}//linguistics
  
    $r13 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='english' and subject='Writting' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows2 = mysql_num_rows($r13);
 while($rw13 = mysql_fetch_array($r13, MYSQL_ASSOC)){
  $writting=$rw13['mark'];}//writting
  
  $r14 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='english' and subject='Comprehension' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows3 = mysql_num_rows($r14);
 while($rw14 = mysql_fetch_array($r14, MYSQL_ASSOC)){
  $comprehension=$rw14['mark'];} 
  
   $r15 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='english' and subject='Creative' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows4 = mysql_num_rows($r15);
 while($rw15 = mysql_fetch_array($r15, MYSQL_ASSOC)){
  $creative=$rw15['mark'];}
  
    $r16 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='english' and subject='Dictation' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows5 = mysql_num_rows($r16);
 while($rw16 = mysql_fetch_array($r16, MYSQL_ASSOC)){
  $dictation=$rw16['mark'];}
   $sum = mysql_query("SELECT Sum(results.mark) AS sum FROM `results` WHERE results.reg = '$reg' AND
results.subject_id = 'ENGLISH' AND results.`session` = '$_SESSION[year]' AND  results.term = '$_SESSION[term]' ")or die(mysql_query());  
 while($rwsum = mysql_fetch_array($sum, MYSQL_ASSOC)){
  $tot=$rwsum['sum'];}
  $average=$tot/6;
   $result1 = mysql_query("SELECT * FROM subjects where type not in(select subject from results where term='$_SESSION[term]' and session='$_SESSION[year]' and reg='$reg') and subject='english' ")or die(mysql_query());
   $averagee=round($average, 2);
 echo"<hr><hr><strong>ENGLISH AVERAGE $averagee% </strong>";
 $co=0;
 if($row==1){print "<a href='index.php?page=updateresults.php&name=spelling&subject=english&reg=$reg&mark=$spelling'><br>
Captured $spelling% for spelling [ edit ]</a><br><br>

";}
if($rows1==1){print "<a href='index.php?page=updateresults.php&name=$linguistics&subject=english&reg=$reg&mark=$linguistics'>Captured $linguistics% for linguistics [ edit ]</a><br><br>

";}
if($rows2==1){print "<a href='index.php?page=updateresults.php&name=writting&subject=english&reg=$reg&mark=$writting'>Captured $writting% for writting [ edit ] </a><br><br>

";}
if($rows3==1){print "<a href='index.php?page=updateresults.php&name=Comprehension&subject=maths&reg=$reg&mark=$comprehension'> Captured $comprehension% for Comprehension [ edit ] </a><br><br>

";}
if($rows4==1){print "<a href='index.php?page=updateresults.php&name=Creative&subject=english&reg=$reg&mark=$creative'> Captured $creative% for Creative [ edit ]</a><br><br>

";}
if($rows5==1){print "<a href='index.php?page=updateresults.php&name=Dictation&subject=english&reg=$reg&mark=$dictation'> Captured $dictation % for Dictation [ edit ] </a><br><br>

";}
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)){
$co++;
$subject=$row1['type'];

if($rows==0 or $rows1==0 or $rows2==0) {
print "<a href='index.php?page=results.php&name=$subject&subject=english&reg=$reg'><p align='left'>$co) $subject</a></p>
";}
}
 ?>
 
  <?php 
 //content
  $r1 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='content' and subject='Agriculture' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $row = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $agriculture=$rw1['mark'];} //spellling
  
   $r12 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='content' and subject='Home Economics' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows1 = mysql_num_rows($r12);
 while($rw12 = mysql_fetch_array($r12, MYSQL_ASSOC)){
  $home=$rw12['mark'];}//linguistics
  
    $r13 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='content' and subject='Shona' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows2 = mysql_num_rows($r13);
 while($rw13 = mysql_fetch_array($r13, MYSQL_ASSOC)){
  $shona=$rw13['mark'];}//writting
  
  $r14 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='content' and subject='Computers' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows3 = mysql_num_rows($r14);
 while($rw14 = mysql_fetch_array($r14, MYSQL_ASSOC)){
  $computers=$rw14['mark'];} 
  
   $r15 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='content' and subject='Scripture' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows4 = mysql_num_rows($r15);
 while($rw15 = mysql_fetch_array($r15, MYSQL_ASSOC)){
  $scripture=$rw15['mark'];}
  
    $r16 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='content' and subject='Science' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows5 = mysql_num_rows($r16);
 while($rw16 = mysql_fetch_array($r16, MYSQL_ASSOC)){
  $science=$rw16['mark'];}
  
  $r17 = mysql_query("SELECT * FROM results where reg='$reg' and subject_id='content' and subject='Social Studies' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' ")or die(mysql_query());
   $rows6= mysql_num_rows($r17);
 while($rw17 = mysql_fetch_array($r17, MYSQL_ASSOC)){
  $ss=$rw17['mark'];}
   $sum = mysql_query("SELECT Sum(results.mark) AS sum FROM `results` WHERE results.reg = '$reg' AND
results.subject_id = 'ENGLISH' AND results.`session` = '$_SESSION[year]' AND  results.term = '$_SESSION[term]' ")or die(mysql_query());  
 while($rwsum = mysql_fetch_array($sum, MYSQL_ASSOC)){
  $tot=$rwsum['sum'];}
  $average=$tot/7;
   $result1 = mysql_query("SELECT * FROM subjects where type not in(select subject from results where term='$_SESSION[term]' and session='$_SESSION[year]' and reg='$reg') and subject='content' ")or die(mysql_query());
   $averagee=round($average, 2);
 echo"<hr><strong>CONTENT AVERAGE $averagee%</strong><br>
";
 $co=0;
 if($row==1){print "<a href='index.php?page=updateresults.php&name=agriculture&subject=maths&reg=$reg&mark=$agriculture'>
Captured $agriculture% for Agriculture [ edit ]</a><br><br>

";}
if($rows1==1){print "<a href='index.php?page=updateresults.php&name=Home Economics&subject=content&reg=$reg&mark=$home'> Captured $home% for Home Economics [ edit ]</a><br><br>

";}
if($rows2==1){print "<a href='index.php?page=updateresults.php&name=shona&subject=content&reg=$reg&mark=$shona'>Captured $shona% for Shona [ edit ] </a><br><br>

";}
if($rows3==1){print "<a href='index.php?page=updateresults.php&name=computers&subject=content&reg=$reg&mark=$computers'> Captured $computers% for Computers [ edit ] </a><br><br>

";}
if($rows4==1){print "<a href='index.php?page=updateresults.php&name=scripture&subject=content&reg=$reg&mark=$scripture'> Captured $scripture% for Scripture [ edit ]</a><br><br>

";}
if($rows5==1){print "<a href='index.php?page=updateresults.php&name=science&subject=content&reg=$reg&mark=$science'> Captured $science % for Science [ edit ] </a><br><br>

";}
if($rows6==1){print "<a href='index.php?page=updateresults.php&name=Social Studies&subject=content&reg=$reg&mark=$ss'> Captured $ss% for Social Studies [ edit ] </a><br><br>

";}
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)){
$co++;
$subject=$row1['type'];

if($rows==0 or $rows1==0 or $rows2==0 or $rows3==0 or $rows4==0 or $rows6==0 or $rows5==0) {
print "<a href='index.php?page=results.php&name=$subject&subject=content&reg=$reg'><p align='left'>$co) $subject</a></p>
";}
}
 ?>
</body>
</html>