<?php
$r1 = mysql_query("SELECT * FROM reports where reg='$_SESSION[reg]' and session='$_SESSION[year]' and term='$_SESSION[term]'  ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $report=$rw1['report'];} ?><center><a href="../admin/report/<?php echo $report; ?>"> <strong>DOWNLOAD STUDENT REPORT FOR <?php echo $_SESSION['name'];?></strong></a></center>
