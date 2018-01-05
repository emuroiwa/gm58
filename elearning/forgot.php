<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script>
function validateEmail(emailField){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if (reg.test(emailField.value) == false) 
        {
            alert('Invalid Email Address');
            return false;
        }

        return true;

}
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
</script>
</head>

<body><?php ?><br>
<br>
<br>
<center><h4>Please enter you username and email to recover your password</h4><br />
<form action="" method="post"   >
        
          <table width="50%" border="0" align="center">
  <tr>
    <td width="27%">Username</td>
    <td width="73%"><input type="text" name="username" id="username" size="25"  /></td>
    </tr>
  <tr>
    <td>Email</td>
    <td><input type="text" name="email" id="email"  size="25"  onblur="validateEmail(this);" /></td>
    </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="password" id="password" value="Get Password"  class="art-button" style="zoom: 1;"/>
      </div></td>
  </tr>
</table>


        
        </form>
<?php
if(isset($_POST['password']))// button referencing
	{
		 if($_POST['password'] == '' OR $_POST['username'] == ''){
	  	 echo ("<SCRIPT LANGUAGE='JavaScript'> window.alert('Enter All fields')
		  javascript:history.go(-1)
		 	</SCRIPT>");  
			exit;
		  }
  function clean($str) {
                            $str = @trim($str);
                            if (get_magic_quotes_gpc()) {
                                $str = stripslashes($str);
                            }
                            return mysql_real_escape_string($str);
                        }
function &generatePassword($length=9, $strength=0) { 
        $vowels = 'aeiuy'; 
        $consonants = 'bcdfghjkmnpqrstwz'; 
        if ($strength & 1) { 
                $consonants .= 'BCDFGJLMNPQRSTVXZ'; 
        } 
        if ($strength & 2) { 
                $vowels .= "AEIUY"; 
        } 
        if ($strength & 4) { 
                $consonants .= '23456789'; 
        } 
        if ($strength & 8) { 
                $consonants .= '@#$%'; 
        } 
  
        $password = ''; 
        $alt = time() % 2; 
        for ($i = 0; $i < $length; $i++) { 
                if ($alt == 1) { 
                        $password .= $consonants[(rand() % strlen($consonants))]; 
                        $alt = 0; 
                } else { 
                        $password .= $vowels[(rand() % strlen($vowels))]; 
                        $alt = 1; 
                } 
        } 
        return $password; 
} 
 	function qoutess($str){
$remove[] = "'";
$remove[] = '"';
$remove[] = "-"; // just as another example
$new = str_replace($remove, "", $str);
return $new;
}
$new_password =& generatePassword(); 
 
$username=clean(qoutess($_POST['username'])); 
$email=clean(qoutess($_POST['email'])); 
$sql="SELECT * FROM users WHERE username='$username' AND email='$email'"; 
$result=mysql_query($sql); 
$num_rows = mysql_num_rows($result); 
	while($rowname = mysql_fetch_array($result, MYSQL_ASSOC))
	  	  {
		  $pwd=$rowname['password'];}

 
if($num_rows==1){ 

?>
        <script language="javascript">

location = 'http://www.ernestmuroiwa.net63.net/forgotemail.php?pwd=<?php echo $pwd; ?>&email=<?php echo $email; ?>'
		</script>
        
        <?php
//mail($email, 'Midlands Christian School e-Schools Software Solution - New Password', $message, 'From: help@mcs.ac.zw'); 
} 
 
else{ 
$content.='<font color="#FF0000">Wrong details provided!!!!! <br />
New password could not be generated.  
If you continue to have issues, please email <a href="mailto:info@midlandschristian.co.zw">info@midlandschristian.co.zw</a> for assistance.</font>'; 
} 
 
 echo $content;

}  ?>
</body>
</html>
