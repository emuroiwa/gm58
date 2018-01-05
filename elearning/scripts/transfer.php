<script type="text/javascript">
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
<br><center>
<strong>
<h3> Student Transfers</h3></strong>
<form action="" method="post" onSubmit="MM_validateForm('reg','','R');return document.MM_returnValue"><table width="615" style="border:1px solid #000000">
  <tr>
    <td width="91">Student Number</td>
    <td width="148"><input name="reg" type="text" id="reg" /></td><td width="49"><input name="Submit" type="submit" value="Find" class="mybutton"/></td>
    
  </tr>
  
</table>
</form>
<br><?php
 if(isset($_POST['Submit'])){
	     $rs1 = mysql_query("select * from student where reg = '$_POST[reg]' and status='enrolled'");
   $rw = mysql_num_rows($rs1);
   if($rw == 0){
   ?>
  <script language="javascript">
 alert("Student Number does not exist");
 location = 'index.php?page=transfer.php'
  </script>
  <?php
  exit;
   } 
$qry= mysql_query("select * from student,student_class where reg='$_POST[reg]' and student=reg")or die(mysql_error());
while($res=mysql_fetch_array($qry)){
$reg= $res['reg'];
$name= $res['name'];
$surname= $res['surname'];
$email= $res['email'];
$shona= $res['shona'];
$sex= $res['sex'];
$address= $res['address'];
$class= $res['class'];
$level= $res['level'];
$contact= $res['contact'];
$image= $res['picture'];
}
?>
<center><table width="609" border="1"  align="center" style="border:1px solid #000000">
  <tr>
    <td width="300" rowspan="10" ><img src="student/<?php echo $image; ?> " height="300" width="300" /></td>
    <td colspan="2" bgcolor="#FFFFFF"  ><strong>Student Details</strong></td>
  </tr><tr bgcolor="#FFFFFF">
    <td><strong>Class</strong></td>
    <td><?php echo "$level"." "."$class"; ?></td>
  </tr><tr bgcolor="#FFFFFF">
    <td><strong>Shona</strong></td>
    <td><?php echo $shona; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="126"><strong>Student number</strong></td>
    <td width="161"><?php echo $reg; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><strong>Name</strong></td>
    <td><?php echo $name; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><strong>Surname</strong></td>
    <td><?php echo $surname; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><strong>Sex</strong></td>
    <td><?php echo $sex; ?></td>
  </tr>
  
  <tr bgcolor="#FFFFFF">
    <td><strong>Contact</strong></td>
    <td><?php echo $contact; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><strong>Email</strong></td>
    <td><?php echo $email; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><strong>Address</strong></td>
    <td><?php echo $address; ?></td>
  </tr>
  
</table>
</center>

	<form action="index.php?page=confirm.php" method="post">
  <br>
  <table width="200" border="0"  align="center">
  <tr>
    <td><label><input type="text" name="regnumber" value="<?php echo $_POST['reg'] ;?>" hidden="true"><?php
	//checking penging corrections
	
	$rs1=mysql_query("select * from student where reg='$_POST[reg]' and status!='ENROLLED'") or die(mysql_error());	  
$rowzz = mysql_num_rows($rs1);
if ($rowzz==1){
$disabled = "disabled='disabled'";
 $title="PUPIL HAS TRANSFERED";}
      else{
              $disabled = "";
			  $title="CONFIRM TRANSFER OF STUDENT";
	  }
echo "<input type='submit' name='transfer', value='                         $title                        ' " . $disabled . "/>";
 
?>
      
    </label></td>
    

</form>
	
</table><?php } ?>