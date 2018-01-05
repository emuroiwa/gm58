<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body><?php  
 include ('opendb.php'); 
 $result1 = mysql_query("SELECT
*
FROM
results , student , student_class WHERE results.reg = student.reg AND results.reg = '$_SESSION[reg]'  AND results.`open` = 'no' AND student.reg = student_class.student ")or die(mysql_query());
	$rowss = mysql_num_rows($result1);
	
		if($rowss==0)
 {
 	echo("<table align='center'  bgcolor='red'><tr><td>Your results are currently supressed sorry</td></tr></table>");  
			exit;}
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))
	  	  
{
	

$name=$row1['name'];
$surname=$row1['surname'];
$level=$row1['level'];
$class=$row1['class'];

$session=$row1['session'];
$term=$row1['term'];
$reg=$row1['reg'];
$subject=$row1['subject_id'];
$grade=$row1['subject'];
$mark=$row1['mark'];


}

		
		

?>
<table width="373" border="0" align="center" style="border:1px solid #000000" bgcolor="#FFFFFF">
  <tr>
    <td width="152">Student number: </td><td width="209"><?php echo $reg; ?> </td></tr><tr>
    <td>Name: </td> <td><?php echo $name; ?> </td> 
    </tr>
  <tr>
    <td width="152">Surname: </td> 
    <td width="209"><?php echo $surname; ?></td>
  </tr>
  <tr>
    <td>Grade: </td> <td><?php echo $level; ?></td> 
  </tr><tr>
    <td>Class: </td> <td><?php echo $class; ?></td> 
  </tr>
  <tr>
    <td>Term: </td>    
  <td><?php echo $term; ?></td> </tr>
  <tr>
    <td width="152">Year: </td> 
    <td width="209"><?php echo $session; ?></td>
  </tr>
</table>
<br><?php
$r1 = mysql_query("SELECT * FROM reports where reg='$reg' and session='$_SESSION[year]' and term='$_SESSION[term]'  ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $report=$rw1['report'];} ?><center>
<a href="../admin/report/<?php echo $report; ?>"> <strong>DOWNLOAD STUDENT REPORT</strong></a></center>
<table width="377" border="0" align="center" style="border:1px solid #000000" cellspacing="1" bgcolor="#FFFFFF">
  <tr bgcolor="blue">
    <th width="242" >Subject</th>
    <th width="126" scope="col">Mark</th>

  </tr><?php 
   $result1112 = mysql_query("SELECT Sum(results.mark) AS w FROM results ,student ,student_class WHERE results.reg = student.reg AND results.term ='$_SESSION[term]' AND results.session ='$_SESSION[year]' AND results.reg = '$_SESSION[reg]'  AND results.`open` = 'no' AND student.reg = student_class.student and subject_id='maths' ")or die(mysql_query());
 while($row12 = mysql_fetch_array($result1112, MYSQL_ASSOC))
	  	  
{$sum=$row12['w'];}
$avg=$sum/3;
  
  $result111 = mysql_query("SELECT * FROM results ,student ,student_class WHERE results.reg = student.reg AND results.term ='$_SESSION[term]' AND results.session ='$_SESSION[year]' AND results.reg = '$_SESSION[reg]'  AND results.`open` = 'no' AND student.reg = student_class.student and subject_id='maths' ")or die(mysql_query());
 while($row1 = mysql_fetch_array($result111, MYSQL_ASSOC))
	  	  
{$a ="<tr><td >{$row1['subject']}</td><td align='center'>{$row1['mark']}</td></tr>";
	echo $a; }?>
    <?php echo "<tr><td align='center'><strong>MATHS AVERAGE $avg%</strong></td></tr>"?>
</table>


<table width="377" border="0" align="center" style="border:1px solid #000000" cellspacing="1" bgcolor="#FFFFFF">
<?php 
   $result1112 = mysql_query("SELECT Sum(results.mark) AS w FROM results ,student ,student_class WHERE results.reg = student.reg AND results.term ='$_SESSION[term]' AND results.session ='$_SESSION[year]' AND results.reg = '$_SESSION[reg]'  AND results.`open` = 'no' AND student.reg = student_class.student and subject_id='english' ")or die(mysql_query());
 while($row12 = mysql_fetch_array($result1112, MYSQL_ASSOC))
	  	  
{$sum=$row12['w'];}
$avg=$sum/6;
  
  $result111 = mysql_query("SELECT * FROM results ,student ,student_class WHERE results.reg = student.reg AND results.term ='$_SESSION[term]' AND results.session ='$_SESSION[year]' AND results.reg = '$_SESSION[reg]'  AND results.`open` = 'no' AND student.reg = student_class.student and subject_id='english' ")or die(mysql_query());
 while($row1 = mysql_fetch_array($result111, MYSQL_ASSOC))
	  	  
{$a ="<tr><td >{$row1['subject']}</td><td align='center'>{$row1['mark']}</td></tr>";
	echo $a; }?>
        <?php echo "<tr><td align='center'><strong>ENGLISH AVERAGE $avg%</strong></td></tr>"?>

</table>
<table width="377" border="0" align="center" style="border:1px solid #000000" cellspacing="1" bgcolor="#FFFFFF">
  <tr bgcolor="blue">
<?php
  $result1112 = mysql_query("SELECT Sum(results.mark) AS w FROM results ,student ,student_class WHERE results.reg = student.reg AND results.term ='$_SESSION[term]' AND results.session ='$_SESSION[year]' AND results.reg = '$_SESSION[reg]'  AND results.`open` = 'no' AND student.reg = student_class.student and subject_id='content' ")or die(mysql_query());
 while($row12 = mysql_fetch_array($result1112, MYSQL_ASSOC))
	  	  
{$sum=$row12['w'];}
$avg=$sum/7;
 $result111 = mysql_query("SELECT * FROM results ,student ,student_class WHERE results.reg = student.reg AND results.term ='$_SESSION[term]' AND results.session ='$_SESSION[year]' AND results.reg = '$_SESSION[reg]'  AND results.`open` = 'no' AND student.reg = student_class.student and subject_id='content' ")or die(mysql_query());
 while($row1 = mysql_fetch_array($result111, MYSQL_ASSOC))
	  	  
{$a ="<tr><td >{$row1['subject']}</td><td align='center'>{$row1['mark']}</td></tr>";
	echo $a; }?>        <?php echo "<tr><td align='center'><strong>CONTENT AVERAGE $avg%</strong></td></tr>"?>
</table>
<!--<center><a href="print.php">Print Online report card</a>
--></body>
</html>