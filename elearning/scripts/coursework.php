<center><table border="1"><tr bgcolor="#FFFFFF"><td><strong>Date of undertaking</strong></td></tr><?php echo "

Please click the date below<br>
 
"; ?><?php

 $rs1=mysql_query("SELECT *
FROM
marksbook ,
class
WHERE
marksbook.class = class.`name` AND
marksbook.`level` = class.`level` AND
marksbook.`session` = '$_SESSION[year]' AND
marksbook.term = '$_SESSION[term]' AND
class.teacher = '$_SESSION[username]'
GROUP BY
marksbook.date
ORDER BY
marksbook.id DESC ") or die(mysql_error());	
if(mysql_num_rows($rs1)==0) 
{
	    ?>
  <script language="javascript">
 alert("NO MARKS HAVE BEEN UPLOADED FOR THIS TERM");
 javascript:history.go(-1)
  </script>
  <?php
  exit;
   
	   } 
while($row1 = mysql_fetch_array($rs1)){
print "<tr><td bgcolor='white'><a href='index.php?page=students_cw.php&date=$row1[date] 'target='_blank'>  <strong>$row1[date]</strong></a></td></tr>";
		}


?></table>