
<?php

 
 mysql_query("DELETE FROM `payment` WHERE stand= '$_GET[stand]' and payment_type<>'Deposit'");
		//Write to log file
			 WriteToLog("Deleted All Payment from stand ID $_REQUEST[stand]",$_SESSION['username']);
  ?>
  <script language="javascript">
  alert("Deleted..............");
history.go(-2);  </script>
