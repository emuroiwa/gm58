<?php
session_start();
include 'opendb.php';
$session = date('Y');
$resulterm = mysql_query("SELECT * FROM term ")or die(mysql_query());
 while($rowterm = mysql_fetch_array($resulterm, MYSQL_ASSOC))
	  	  
{
$term=$rowterm['term'];
}
	  function clean($str) {
                            $str = @trim($str);
                            if (get_magic_quotes_gpc()) {
                                $str = stripslashes($str);
                            }
                            return mysql_real_escape_string($str);
                        }
											function qoutess($str){
$remove[] = "'";
$remove[] = '"';
$remove[] = "-"; // just as another example
$new = str_replace($remove, "", $str);
return $new;
}
$username = clean(qoutess($_POST["username"]));
$password = clean(qoutess($_POST["password"]));



  if($username == '' OR $password == ''){
	  	 echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Enter All fields')
		  javascript:history.go(-1)
		 	</SCRIPT>");  
			exit;
		  }
		  
		  
		   $resul = mysql_query("SELECT * from users where username='$username' AND password = '$password' and suspend='0'");
	

		  $rows = mysql_num_rows($resul);
	if($rows==1)
 {
 	echo("<SCRIPT LANGUAGE='JavaScript'> window.alert('You Have Been Suspended Contact The Adminstrator')
		  javascript:history.go(-1)
		 	</SCRIPT>");  
			exit;

 }
 else{


$query = "SELECT * from users where username='$username' AND password = '$password' and suspend='1'";
$result = mysql_query($query);
$rows=mysql_fetch_array($result);
$access=$rows['access'];

$q1=$rows['namee'];
$q2=$rows['surname'];
$full=$q1." ".$q2;
$_SESSION['year'] = $session;
$_SESSION['term'] = $term;
$_SESSION['username'] = $username;

$_SESSION['name'] = $full;
$_SESSION['access'] = $access;
if(!$result)
{
	die( "\n\ncould'nt send the query because".mysql_error());
	exit;
}
	$row = mysql_num_rows($result);
	if($row==1)
 {
 	header("location: scripts/index.php");
	 $time = date('m/d/Y-h:m:s');$date = date('m/d/Y');
	 $res = mysql_query("insert into audit_tray(id,username,operation,time,date,login) values('NULL','$username','Logged In','$time','$date','login')") or die(mysql_error());
	exit;
 }

  else
 {
echo("<SCRIPT LANGUAGE='JavaScript'> window.alert('Wrong Username And Password Combination')
		 javascript:history.go(-1)
		 	</SCRIPT>");   
	
}
}
?>