      <?php
			include ('aut1.php');		 
	  if (isset($_POST['Submit'])){
	  
	 $result = mysql_query("SELECT * FROM users where username='$_POST[reg]' ")or die(mysql_query());
		 
	   
  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	  	  
{

echo "{$row['password']}";
}
}

?>