<?php
  if(isset($_POST['Submit'])){
   include "../opendb.php";
   
     $date = date('m/d/Y');
   $name = $_POST['name'];
   $surname = $_POST['surname'];
   
   $id_no = $_POST['id_first_digit']."-".$_POST['id_second_digit']."-".$_POST['id_third_letters']."-".$_POST['id_forth_digit'];
   $rs1 = mysql_query("select * from users where username = '$_POST[username]'");
   $rw = mysql_num_rows($rs1);
   if($rw == 1){
   ?>
  <script language="javascript">
 alert("Username already in use");
 location = 'index.php?page=creates.php'
  </script>
  <?php
  exit;
   }
   $rs1 = mysql_query("select * from users where idnumber = '$id_no'");
   $rw = mysql_num_rows($rs1);
   if($rw == 1){
   ?>
  <script language="javascript">
 alert("ID Number already in use");
 location = 'index.php?page=creates.php'
  </script>
  <?php
  exit;
   }
   
  if(strlen($_POST['password']) < 8 ){
   ?>
  <script language="javascript">
 alert("Password should be above 8 characters");
 location = 'index.php?page=registration.php'
  </script>
  <?php
  exit;
   }
   if($_POST['password']!=$_POST['password2']){
   ?>
  <script language="javascript">
 alert("Password did not match with confirm password");
 location = 'index.php?page=creates.php'
  </script>
  <?php
  exit;
   }
   
   else{
 $rs = mysql_query("insert into users(id,namee,surname,sex,email,address,username,password,idnumber,status,date,access,suspend) values ('NULL','$_POST[name]','$_POST[surname]','$_POST[sex]','$_POST[email]','$_POST[address]','$_POST[username]','$_POST[password]','$id_no','1','$date','$_POST[access]','1')")  or die(mysql_error());
  
  if($rs){
  ?>
  <script language="javascript">
 alert("User successfully created");
 location = 'index.php?page=creates.php'
  </script>
  <?php
  
  }
  else
  {
  echo "problem occured";
  }
  }
  }
?>

<script language="javascript">
function lettersOnly(evt) {
evt = (evt) ? evt : event;
var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
((evt.which) ? evt.which : 0));
if ( (charCode < 65 || charCode > 90 ) &&
(charCode < 97 || charCode > 122)) {
if(charCode != 8){
alert("Enter letters only.");
return false;
}

}
return true;
}
</script>
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
<center>
<form action="" method="post" onSubmit="MM_validateForm('name','','R','surname','','R','id_first_digit','','RisNum','id_second_digit','','RisNum','id_forth_digit','','RisNum','contact','','RisNum','email','','RisEmail','username','','R','password','','R','password2','','R');return document.MM_returnValue"><table width="470" border="1" bordercolor="black" align="center">
<tr>
	        <td colspan="2"><font color="black"><div align="center"><strong>Personal Information</strong></div></font>
        </td>
	       </tr>
 
    <td width="234">Name:</td>
    <td width="226"><input name="name" type="text" size="30" id="name"onKeyPress="return lettersOnly(event)"></td>
  </tr>
  <tr>
    <td>Surname:</td>
    <td><input name="surname" type="text" size="30" id="surname"onKeyPress="return lettersOnly(event)"></td>
  </tr>
  <tr>
    <td>Sex:</td>
    <td><select name="sex">
    <option>Male</option>
    <option>Female</option>
    </select></td>
  </tr>
  <tr>
    <td>I.D Number:</td>
<td><input name="id_first_digit" type="text" id="id_first_digit" size="2" maxlength="2"  />-<input name=" id_second_digit" type="text" maxlength="8" id="id_second_digit" size="9" />-<select name="id_third_letters"><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option><option>J</option><option>K</option><option>L</option><option>M</option><option>N</option><option>O</option><option>P</option><option>Q</option><option>R</option><option>S</option><option>T</option><option>U</option><option>V</option><option>W</option><option>X</option><option>Y</option><option>X</option></select>
            -<input name="id_forth_digit" type="text" id="id_forth_digit" size="2" maxlength="2"  /></td>
  </tr><tr>
            <td>Contact Address</td>
            <td>
              <textarea name="address" id="address"></textarea>            </td>
          </tr>
  <tr>
    <td>Contact:</td>
    <td><input name="contact" type="text" size="30" id="contact"></td>
  </tr>
  <tr>
    <td>Email:</td>
    <td><input name="email" type="text" size="30" id="email"></td>
  </tr>
  <tr>
    <td>Job Description:</td>
    <td><select name="access">
    <option value="3">Teacher</option>
    <option value="2">Headmaster</option>
    <option value="1">System Admin</option>
        </select></td>
  </tr>
 <tr>
	        <td colspan="2"><font color="black"><div align="center"><strong>Login Details</strong></div></font>
        </td>
	       </tr><tr>
    <td>Username:</td>
    <td><input name="username" type="text"  maxlength="12" size="30" id="username"></td>
  </tr>
  <tr>
    <td>Password:</td>
    <td><input name="password" type="password" size="30" id="password"></td>
  </tr>
  <tr>
    <td>Confirm Password:</td>
    <td><input name="password2" type="password" size="30" id="password2"></td>
  </tr>
  <tr>
    <td colspan="2"><label>
      <center><input type="submit" class="mybutton" name="Submit" id="Submit" value="Submit"></center>
    </label></td>
    </tr>
</table>
</form>
</center>