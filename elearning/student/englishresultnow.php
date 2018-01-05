<?php 
   $result1112 = mysql_query("SELECT Sum(results.mark) AS w FROM results ,student ,student_class WHERE results.reg = student.reg AND results.term ='$term' AND results.session ='$year' AND results.reg = '$_SESSION[reg]' AND student.reg = student_class.student and subject_id='english' ")or die(mysql_query());
 while($row12 = mysql_fetch_array($result1112, MYSQL_ASSOC))
	  	  
{$sum=$row12['w'];}
$avg=$sum/6; $averagee=round($avg, 2);?> <?php echo "<strong>ENGLISH AVERAGE $averagee%</strong>"?>
<table width="377" border="1" bordercolor="#000000" align="center" style="border:1px solid #000000" cellspacing="1" bgcolor="#FFFFFF">
  <tr bgcolor="blue">
    <th width="242" >Subject</th>
    <th width="126" scope="col">Mark</th><?php
  
  $result111 = mysql_query("SELECT * FROM results ,student ,student_class WHERE results.reg = student.reg AND results.term ='$term' AND results.session ='$year' AND results.reg = '$_SESSION[reg]'   AND student.reg = student_class.student and subject_id='english' ")or die(mysql_query());
 while($row1 = mysql_fetch_array($result111, MYSQL_ASSOC))
	  	  
{$a ="<tr><td >{$row1['subject']}</td><td align='center'>{$row1['mark']}%</td></tr>";
	echo $a; }?>
       

</table>