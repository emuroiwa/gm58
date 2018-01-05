<center><table border="1"><tr bgcolor="#FFFFFF"><td><strong>Date of fortnightly tests</strong></td></tr><?php echo "

Please click the date below to view marks....<br>
 
"; ?><?php

 $rs1=mysql_query("SELECT *
FROM
marksbook
WHERE
reg='$_SESSION[reg]' AND marksbook.status='0'
GROUP BY
marksbook.date
ORDER BY
marksbook.id DESC ") or die(mysql_error());	
if(mysql_num_rows($rs1)==0) 
{
	    ?>
  <script language="javascript">
 alert("NO SUBJECT MARKS HAVE BEEN UPLOADED FOR THIS TERM");
 javascript:history.go(-1)
  </script>
  <?php
  exit;
   
	   } 
  
while($row1 = mysql_fetch_array($rs1)){
print "<tr><td bgcolor='white'><a href='index.php?page=coursewk.php&date=$row1[date]'target='_blank'>  <strong>$row1[date]</strong></a></td></tr>";
		}


?></table>