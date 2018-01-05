<?php


mysql_query("update correct set status='corrected'
 where idc='$_REQUEST[money]'") or die (mysql_error());

      header("location:index.php?page=correction.php"); 

	
  
		?>