<?php 
   $result1112 = mysql_query("SELECT Sum(cw.mark) AS w FROM cw ,student ,student_class WHERE cw.reg = student.reg AND cw.term ='$_SESSION[term]'  AND cw.reg = '$_SESSION[reg]'  AND student.reg = student_class.student and subject_id='maths' AND cw.session = '$_SESSION[year]' ")or die(mysql_query());
 while($row12 = mysql_fetch_array($result1112, MYSQL_ASSOC))
	  	  
{$sum=$row12['w'];}
  $result111 = mysql_query("SELECT * FROM cw ,student ,student_class WHERE cw.reg = student.reg AND cw.term ='$_SESSION[term]'  AND cw.reg = '$_SESSION[reg]'   AND student.reg = student_class.student and subject_id='maths' AND cw.session = '$_SESSION[year]' order by subject ")or die(mysql_query());
   $rows1 = mysql_num_rows($result111);

$avg=$sum/3;
$avgfuti=$sum/$rows1;
  $averagee=round($avgfuti, 2);
 ?> <?php echo "<strong>MATHS AVERAGE $averagee% FROM $rows1 TESTS TAKEN</strong>"?><table width="421" border="1" bordercolor="#000000"align="center" style="border:1px solid #000000" cellspacing="1" bgcolor="#FFFFFF">
  <tr bgcolor="blue">
     <th width="114" >Subject</th>
    <th width="132" scope="col">Description</th> 
      <th width="100" >Date Of Test</th>
    <th width="60" scope="col">Mark</th>

  </tr><?php 
 
  

 while($row1 = mysql_fetch_array($result111, MYSQL_ASSOC))
	  	  
{$a ="<tr><td >{$row1['subject']}</td><td >{$row1['description']}</td><td >{$row1['date']}</td><td align='center'>{$row1['mark']}%</td></tr>";
	echo $a; }?>
   
</table>