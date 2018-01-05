<?php

$qry= mysql_query("select * from student where reg='$_SESSION[reg]'")or die(mysql_error());
while($res=mysql_fetch_array($qry)){
$reg= $res['reg'];
$name= $res['name'];
$surname= $res['surname'];
$email= $res['email'];
//$idnum= $res['idnum'];
$sex= $res['sex'];
$address= $res['address'];
//$pcontact= $res['pcontact'];
//$pcontact= $res['pcontact'];
$contact= $res['contact'];
$image= $res['picture'];
}
?>
<center><table width="609" border="1"  align="center" style="border:1px solid #000000">
  <tr>
    <td width="300" rowspan="10" ><img src="../scripts/student/<?php echo $image; ?> " height="300" width="300" style="margin-top: 10px; margin-right: 10px; margin-bottom: 10px; margin-left: 10px; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: rgb(157, 196, 215); border-right-color: rgb(157, 196, 215); border-bottom-color: rgb(157, 196, 215); border-left-color: rgb(157, 196, 215); border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px;" alt="" class="art-lightbox"  /></td>
    <td colspan="2" bgcolor="#FFFFFF"  ><strong>Student Details</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="126">Student number</td>
    <td width="161"><?php echo $reg; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>Name</td>
    <td><?php echo $name; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>Surname</td>
    <td><?php echo $surname; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>Sex</td>
    <td><?php echo $sex; ?></td>
  </tr>
  
  <tr bgcolor="#FFFFFF">
    <td>Contact</td>
    <td><?php echo $contact; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>Email</td>
    <td><?php echo $email; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>Address</td>
    <td><?php echo $address; ?></td>
  </tr>
  
</table>
</center>