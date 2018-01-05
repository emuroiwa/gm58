<br />
<strong>Uploaded documents.</strong>
<table width="100%" border="0" align="center" style="border:1px solid #000000" >

    <td width="138"bgcolor="#CCCCCC">Description</td>
      <td width="92"bgcolor="#CCCCCC">Subject</td>
    <td width="118"bgcolor="#CCCCCC">Date</td>
     <td width="92"bgcolor="#CCCCCC">DOWNLOAD</td>
  </tr><?php

include '../opendb.php';

$rs = mysql_query("select * from upload where subject= '$_REQUEST[subject]' and user= '$_REQUEST[level]'")or die(mysql_error());

while($row = mysql_fetch_array($rs))
{
$description=$row['description'];
$uploader=$row['subject'];
$dates = $row['date'];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style3 {font-size: 12px}
.style5 {font-size: 12px; font-style: italic; }
-->
</style>
</head>

<body>

  
  <tr>
    <td><?php 
$song = "../admin/upload/".$row['script']; echo $description; ?></td>
    <td><?php echo $uploader; ?></td>
    <td><?php echo $dates; ?></td>
    <td><a href='<?php echo $song; ?>'>Download</a></td><?php } ?>
  </tr>
 </table>
</body>
</html>
