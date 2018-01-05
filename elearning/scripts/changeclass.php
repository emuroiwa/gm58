 <?php
  	$date = date('m/d/Y'); 
$newyear='01/01/'.date('Y');
	if($newyear==$date){
 mysql_query("update student_class set level='COMPLETED' where
 session!='$_SESSION[year]' and level='7'")or die(mysql_query());
	 
	mysql_query("update student_class set level='7' where
 session!='$_SESSION[year]' and level='6'")or die(mysql_query());
 
mysql_query("update student_class set level='6' where
 session!='$_SESSION[year]' and level='5'")or die(mysql_query());

mysql_query("update student_class set level='5' where
 session!='$_SESSION[year]' and level='4'")or die(mysql_query());
 
mysql_query("update student_class set level='4' where
 session!='$_SESSION[year]' and level='3'")or die(mysql_query());

mysql_query("update student_class set level='3' where
 session!='$_SESSION[year]' and level='2'")or die(mysql_query());
		
 mysql_query("update student_class set level='2' where
 session!='$_SESSION[year]' and level='1'")or die(mysql_query());

	}
  ?>