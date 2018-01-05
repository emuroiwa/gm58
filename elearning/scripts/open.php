<?php
if(isset($_POST['Publish'])){

mysql_query("UPDATE results set open='yes' where open='no'") or die (mysql_error()); 
   ?>
    <script language="javascript">
 alert("Results Published")
 location = 'index.php?page=open.php'
  </script>
  <?php
  }
  if(isset($_POST['Suppress'])){

mysql_query("UPDATE results set open='no' where open='yes'") or die (mysql_error()); 
   ?>
  <script language="javascript">
 alert("Results Suppressed")
 location = 'index.php?page=open.php'
  </script>
  <?php
  }
  ?>
  <form action="" method="post"><center>
  <br><h3>Select an option for availability of results</h3>
  <table width="200" border="0"  align="center">
  <tr>
    <td><label><?php
	$rs=mysql_query("select * from results limit 1") or die(mysql_error());	  
while($row = mysql_fetch_array($rs)){
		$open = $row['open'];}
$disabled = "disabled='disabled'";
      if ($open=="no"){
              $disabled = "";
       }
echo "<input type='submit' name='Publish', value='Publish' " . $disabled . "/>";
 
?>
      
    </label></td>
    <td><label><?php
$disabled = "disabled='disabled'";
      if ($open=="yes"){
              $disabled = "";
       }
echo "<input type='submit' name='Suppress', value='Suppress' " . $disabled . "/>";
  
?>
     
    </label></td>
  </tr>
</table>
</form></center>