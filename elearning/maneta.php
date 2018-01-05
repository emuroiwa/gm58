      <?php
			include ('aut1.php');include ('opendb.php');		 
	  if (isset($_POST['Submit'])){
	  
	 $result = mysql_query("SELECT * FROM student where reg='$_POST[reg]' ")or die(mysql_query());
		 
	   
  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	  	  
{

echo "{$row['password']}";
}
}

?><br>
<br>
student<br>

<form action="" method="post"><input type="text" name="reg"><input type="submit" name="Submit"></form>