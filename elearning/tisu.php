<?php  if(isset($_POST['Submit'])){
session_start();
include 'opendb.php';

	  function clean($str) {
                            $str = @trim($str);
                            if (get_magic_quotes_gpc()) {
                                $str = stripslashes($str);
                            }
                            return mysql_real_escape_string($str);
                        }
$username = clean($_POST["username"]);
$password = clean($_POST["password"]);

  if($username == '' OR $password == ''){
	  	 echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Enter All fields')
		  javascript:history.go(-1)
		 	</SCRIPT>");  
			exit;
		  }
		  
		  
		$user=sha1($username);
$pwd=sha1($password);
//echo $pwd;echo "<br>
//$user";exit;
 $result ="";
$query = "SELECT * from users where username='$username' AND password = '$password' ";
$result = mysql_query($query);
$rows=mysql_fetch_array($result);
$access=$rows['access'];

$_SESSION['user'] = $username;

$_SESSION['name'] = $full;
$_SESSION['access'] = $access;
if(!$result)
{
	die( "\n\ncould'nt send the query because".mysql_error());
	exit;
}
	
	if(mysql_num_rows($result)==1 && $access=='license')
 {
 	header("location: license.php");
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
?><form action="" method="post" name="login" id="form-login">
<fieldset class="input" style="border: 0 none;">
<p id="form-login-username">
 <label for="modlgn_username">Username</label>
<br>
 <input name="username" type="password" class="smalltxt" id="username">
</p>
<p id="form-login-password">
 <label for="modlgn_passwd">Password</label>
<br>
 <input name="password" type="password" class="smalltxt" id="password">
</p>
 
<input type="submit" value="Login" name="Submit" class="art-button" style="zoom: 1;"> 
<br>
<a href="#">Forgot your password?</a></center>
</fieldset>
 
 
 
 
 
 
</form>