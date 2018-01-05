<?php  if(isset($_POST['transfer'])){
		echo"$_POST[regnumber]";
		
 mysql_query("update student set status='TRANSFERED' where reg='$_POST[regnumber]' ") or die (mysql_error()); 
 mysql_query("DELETE FROM `student_class` WHERE student= '$_POST[regnumber]'") or die (mysql_error());
 ?>
  <script language="javascript">
 alert("Student Confirmed as TRANSFED")
location = 'index.php?page=transfer.php' 
  </script>
  <?php
  }?>