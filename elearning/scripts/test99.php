 <?php
 include 'opendb.php';
  $r1 = mysql_query("SELECT * FROM student_class")or die(mysql_query());
   $rows = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $level=$rw1['level'];
  $newlevel=$level+1;
echo $newlevel;
  mysql_query("update student_class set level='$newlevel' where
 session!='$_SESSION[year]'") or die (mysql_error());
  
  } ?>