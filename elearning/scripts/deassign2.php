<?php

	 $date = date('m/d/Y'); 
	   $rs1 = mysql_query("delete from class where teacher= '$_GET[id]'");
  
	
	?>
    <script language="javascript">
 alert("Successful Deassignment");
 javascript:history.go(-2)
  </script>
    <?php

?>