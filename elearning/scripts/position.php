<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php  $pos = mysql_query("SELECT Avg(average.average) AS a FROM `average` where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg'  ")or die(mysql_query());
 while($posrow = mysql_fetch_array($pos, MYSQL_ASSOC)){
  $posit=$posrow['a'];
  }
  $poscheck = mysql_query("SELECT * FROM average where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg' and subject_id = 'OVERALL' ")or die(mysql_query());
 if(mysql_num_rows($poscheck)==1){
	mysql_query("update average set average='$posit' where
 session='$_SESSION[year]' and `term`='$_SESSION[term]' and student='$reg' and subject_id = 'OVERALL'") or die (mysql_error());  
	 }if(mysql_num_rows($poscheck)==0){
	  mysql_query("INSERT INTO average (student,subject_id,class,grade,average,session,term)
VALUES
('$reg','OVERALL','$class','$grd','$posit','$_SESSION[year]','$_SESSION[term]')") or die (mysql_error());
	  } ?>
</body>
</html>