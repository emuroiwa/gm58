<?php
$subject = 'Midlands Christian School Login details';
$message = '<strong>Good Day</strong>,<br>
This email serves to inform you that $name1 $sname has been entered on to our online database.<br>
 $name1 $sname has been given this unique student number<br>
<strong>$_POST[reg]</strong>
Please use this Student Number <strong>$_POST[reg]</strong> to create your Midlands Christian School online account<br>
Please follow this link http://www.mcs.ac.zw/ to do so.<br>
<br>
<br>
For more info please call us on<br>
054-224930 / 054-223153<br>
';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Midlands Christian School <help@mcs.ac.zw>' . "\r\n";
mail($_POST['email'], $subject, $message, $headers);


?>

