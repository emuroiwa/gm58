<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<center><?php echo "<b>$_SESSION[name]</b> your subjects below 
<br>
For term $_SESSION[term]  $_SESSION[year]<br>
Please click to <em>UPLOAD MATERIAL</em><br>
 <br>
"; ?>

<?php  $result1 = mysql_query("SELECT * FROM subjects where teacher='$_SESSION[username]' ")or die(mysql_query());
$rows = mysql_num_rows($result1);
	if($rows==0)
 {
 	echo("You have not been allocated subjects yet please contact the adminstrator now");  
			exit;

 	  
 }
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)){
	
$level=$row1['level'];
$subject=$row1['subject'];
$id=$row1['id'];

print "<a href='index.php?page=upload.php&id=$level&name=$subject'><hr>Form $level $subject</a><br>

";
}
?>
</body>
</html>