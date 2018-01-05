<?php
$result1 = mysql_query("SELECT * FROM term ")or die(mysql_query());
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))
	  	  
{
$term=$row1['term'];
}
if(isset($_POST['Publish'])){
 
if($term==3)
 {
mysql_query("UPDATE term set term=1 ") or die (mysql_error()); 
header("location: index.php");
exit;
 	}
	else{
		$termnow=$term+1;

mysql_query("UPDATE term set term='$termnow' ") or die (mysql_error()); 
   echo"Previous term was $_SESSION[term] now term is $termnow year $_SESSION[year]";
  }}

  ?><center><h3><?php    echo"<br>
Current term is $term"; $nt=$term+1;
?></h3>
  <form action="" method="post">
  <br>
  <table width="200" border="0"  align="center">
  <tr>
    <td><label><?php
	$rs=mysql_query("select * from results where session='$_SESSION[year]' and term='$_SESSION[term]' and open='yes' limit 1") or die(mysql_error());	  
$rows = mysql_num_rows($rs);
$disabled = "disabled='disabled'";
      if ($rows==1){
              $disabled = "";
       }
echo "<input type='submit' name='Publish', value='                         OPEN TERM $nt                        ' " . $disabled . "/>";
 
?>
      
    </label></td>
    
</table>
</form></center>