<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript">
<!--
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
//-->
</script>
</head>

<body>
 <form action="" method="post" onsubmit="MM_validateForm('title','','R','news','','R');return document.MM_returnValue">

    
 <center>
 
 

                                            <table cellpadding="5" width="31%" border="0" frame="border" align="center">
                                              
        
                                                         
        <p>UPLOAD NOTICE</p>
                                               
                                                  <tr>
                                                 
        								</tr><tr>
                                        <td><label><font size="2"olor="black">Title:</font></label>
                                         
                                          <input name="title" type="text" id="title" maxlength="17"/>
                                         </td>
                                        </tr>
                                                    <td>
                                                      <label><font size="2"  color="black">Notice:</font></label><textarea name="news" cols="40" rows="7" id="news"></textarea>
                                                      </td>
                                              </tr>
                                              <tr align="center">
                                                    <td colspan="2" align="center"><input type="submit" value="Save" name="save" /></td>
                                              </tr>
</table></center></form>

<?php 
//include("../conn/functions.php");
include("opendb.php");
if(isset($_POST['save'])){

$day=date("Y-m-d H:i:s");


$sql="INSERT INTO `news`(`news`,`title`,`date`)
VALUES ('$_POST[news]','$_POST[title]','$day')";
if (!mysql_query($sql))
{
die('Error: ' . mysql_error());
}
 ?>
  <script language="javascript">
 alert("Notice Uploaded ");
 javascript:history.go(-1);
  </script>
  <?php

}
?> 
</body>
</html>
