<?php $subject = 'Midlands Christian School Password Recovery';
$message = '<strong>Good Day</strong>,<br><br>
<br>
<br>
Some one (hopefully you) requested a new password be generated for your account on Midlands Christian School e-Schools Software Solution. 
Below is the newly generated password: <br>
<br>
<br>

 
Password: '.$_GET['pwd'].' <br>
<br>
<br>
<br>

 
Once you log-in, please change your password. 
 
Thank You, 
Midlands Christian School e-Schools Software Solution Support Team 

Please follow this link http://mcs.ac.zw/elearning/index.php?767013ce0ee0f6d7a07587912eba3104cfaabc15=b3Blbi5waHA to do so.<br>
<br>
<br>
For more info please call us on<br>
054-224930 / 054-223153<br><br>
<br>
<br>

';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Midlands Christian School <info@midlandschristian.co.zw>' . "\r\n";
mail($_GET['email'], $subject, $message, $headers);
?> <script language="javascript">
		alert("Check Your email inbox");
  javascript:history.go(-1)
  </script>