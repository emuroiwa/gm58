<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body><table width="100%" border="0">
					  <tr> 
                                  <td  width="119">Name</td>
                        <td  width="125">Surname</td>
<?php 

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) 
		echo 'Internet explorer';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE) 
		echo 'Mozilla Firefox';
		
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE) 
			echo 'Google Chrome';
			
			else 
				echo 'Something else';

?></tr></table>
</body>
</html>