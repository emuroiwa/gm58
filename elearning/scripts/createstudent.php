 <?php
if(isset($_POST['submit'])){
  $date = date('m/d/Y'); 
  $session = date('Y');
  $name=strtolower("$_POST[name]");
   $surname=strtolower("$_POST[surname]");
   $name1=ucfirst($name);
   $sname=ucfirst($surname);
  $dob=$_POST["day"]."/".$_POST["month"]."/".$_POST["year"] ; 
    $rs1 = mysql_query("select * from student where reg = '$_POST[reg]' and status='ENROLLED'");
   $rw = mysql_num_rows($rs1);
   if ( $_POST["day"]>29 && $_POST["month"]==2  ){
	     ?>
  <script language="javascript">
			alert('Enter correct day for Febuary.');
			 location = 'index.php?page=createstudent.php'
  </script>
  <?php
  exit;
		}
			if ( $_POST["day"]==31  && $_POST["month"].val()==4  ){
				  ?>
  <script language="javascript">
			alert('Enter correct day for April.');
			 location = 'index.php?page=createstudent.php'
  </script>
  <?php
  exit;
		}
		if ( $_POST["day"]==31  && $_POST["month"]==6  ){
			  ?>
  <script language="javascript">
			alert('Enter correct day for June.');
			 location = 'index.php?page=createstudent.php'
  </script>
  <?php
  exit;
		}
		if ( $_POST["day"]==31  && $_POST["month"]==9  ){
			  ?>
  <script language="javascript">
			alert('Enter correct day for September.');
			 location = 'index.php?page=createstudent.php'
  </script>
  <?php
  exit;
		}
		if ( $_POST["day"]==31  && $_POST["month"]==11  ){
			  ?>
  <script language="javascript">
			alert('Enter correct day for November.');
			 location = 'index.php?page=createstudent.php'
  </script>
  <?php
  exit;
		}
   
   
   if($rw == 1){
   ?>
  <script language="javascript">
 alert("Registration Number Already In Use");
 location = 'index.php?page=createstudent.php'
  </script>
  <?php
  exit;
   }/*function get_file_extension($file_name) {
    return end(explode('.',$file_name));
}*/
    $fn = time().$_FILES['file']['name'];
		  	if(!move_uploaded_file($_FILES['file']['tmp_name'],"student/".$fn)){?>
        <script language="javascript">
		alert("PLEASE CHOOSE A PICTURE");
		 location = 'index.php?page=createstudent.php'
		</script>
        <?php
		exit;}

   else{
	   //email parent
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
//mail($_POST['email'], $subject, $message, $headers);
//$pwd=sha1('default');
//insert into db	
	mysql_query("INSERT INTO student (reg,name,surname,address,email,contact,sex,dob,password,dates,picture)
VALUES
('$_POST[reg]','$name1','$sname','$_POST[address]','$_POST[email]','$_POST[contact]','$_POST[sex]','$dob','default','$date','$fn')") or die (mysql_error());

	mysql_query("INSERT INTO student_class (level,class,student,session,shona)
VALUES
('$_POST[level]','$_POST[class]','$_POST[reg]','$session','$_POST[shona]')") or die (mysql_error());




		?>
        <script language="javascript">

location = 'http://www.ernestmuroiwa.net63.net/mcsemail.php?reg=<?php echo $_POST['reg']; ?>&name=<?php echo $name1;?>&surname=<?php echo $sname; ?>&email=<?php echo $_POST['email']; ?>'
		</script>
        
        <?php
		}
		


		
			
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><link media="all" href="../../WRL/admin/index.php_files/widget49.css" type="text/css" rel="stylesheet">
<style type="text/css">
.underlinemenu{
font-weight: bold;
width: 100%;
}
#btaks{

visibility:hidden;}

.underlinemenu ul{
padding: 6px 0 7px 0; /*6px should equal top padding of "ul li a" below, 7px should equal bottom padding + bottom border of "ul li a" below*/
margin: 0;
text-align: right; //set value to "left", "center", or "right"*/
}

.underlinemenu ul li{
display: inline;
}

.underlinemenu ul li a{
color: #494949;
padding: 6px 3px 4px 3px; /*top padding is 6px, bottom padding is 4px*/
margin-right: 20px; /*spacing between each menu link*/
text-decoration: none;
border-bottom: 3px solid gray; /*bottom border is 3px*/
}

.underlinemenu ul li a:hover, .underlinemenu ul li a.selected{
border-bottom-color: black;
}

</style>

	
    <style type="text/css">
<!--
.style8 {font-size: 14px; color: #000000;}
.style9 {font-size: 12}
.style11 {
	font-size: 24px;
	font-weight: bold;
}
.style12 {font-size: 14px}
.style13 {
	font-size: 16px;
	font-style: italic;
}
.style14 {font-size: 12px}
-->
    </style><script language="javascript">
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
</script><script>
function validateEmail(emailField){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if (reg.test(emailField.value) == false) 
        {
            alert('Invalid Email Address');
            return false;
        }

        return true;

}
</script>
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
</head>
<body>
<center>
	<form action="" method="post"  enctype="multipart/form-data" name="addroom" onSubmit="MM_validateForm('reg','','R','name','','R','surname','','R','email','','RisEmail','contact','','RisNum','id_first_digit','','RinRange0:99','id_second_digit','','RinRange0:9999999','id_forth_digit','','RinRange0:99','address','','R');return document.MM_returnValue" >
	   
	  
	  <table width="445"  border="1" bordercolor="black" align="center" >
<tbody>
      <tr>
	        <td colspan="2" class="style8 style2 style9"><div align="center"><strong><font size="+1">Student Information</font></strong></div>
        </td>
	       </tr>
      <tr>
      <td>Student Number</td>
      <td>
        <input name="reg" type="text" readonly value="<?php 
	error_reporting(0);
	$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$numbers ="0123456789";
	$length = 4;
            
		for ($p = 0; $p < $length; $p++) {
			$code = $characters[mt_rand(0, strlen($characters))];
			$codee .= $numbers[mt_rand(0, strlen($numbers))];
			$date=date('y');
			$reg= "MCS".$date.$codee.$code;
		}	
		echo $reg;
        ?>" size="30" id="reg" />       </td>
        </tr>
        <tr>
      <td>Name</td>
      <td>
        <input name="name" type="text" id="name" size="30" onKeyPress="return lettersOnly(event)" />       </td>
        </tr>
          <tr>
            <td width="205">Surname</td>
            <td width="225">
            <input name="surname" type="text" id="surname" size="30" onKeyPress="return lettersOnly(event)"  />              </td>
    </tr>
          <tr>
	  <td nowrap="nowrap">Date of birth</td>
	  <td nowrap="nowrap"> <select name="day" id="day">
      <?php for($xc = 1; $xc <= 31; $xc++){ ?>
      	<option value="<?php echo $xc;?>"><?php echo $xc;?></option>
      <?php } ?>
      </select>
	<!--<input name="day" type="text" id="day" size="4" maxlength="2">-->
	  <select name="month" id="month">
	  <option value="1">January</option>
	   <option value="2">February</option>
	   <option value="3">March</option>
	   <option value="4">April</option>
	   <option value="5">May</option>
	   <option value="6">June</option>
	   <option value="7">July</option>
	   <option value="8">August</option>
	   <option value="9">September</option>
	   <option value="10">October</option>
	   <option value="11">November</option>
	   <option value="12">December</option>
	 </select>
	  <select name="year" id="year">
      <?php $date = date('Y');
	  $d=$date-4;for($xc = 1997; $xc < $d; $xc++){ ?>
      	<option value="<?php echo $xc;?>"><?php echo $xc;?></option>
      <?php } ?>
      </select></td></tr>
      <tr>
            <td>Sex</td>
            <td>
              <select name="sex" size="1"><option>male</option><option>female</option></select>            </td>
          </tr>
        <tr>
  <td width="205"> <span class="style1 style9">Grade</span></td>
  <td width="225">
    <select name="level"><option>1</option>
    <option>2</option>
    <option>3</option><option>4</option>
    <option>5</option>
    <option>6</option><option>7</option>
    
    </select></td>
</tr>   <tr>
  <td width="205"> <span class="style1 style9">Class </span></td>
  <td width="225">
    <select name="class"><option>A</option>
    <option>B</option>
   
    
    </select></td>
</tr>  
<tr>
       <td><span class="style12">Student  Picture</span></td>
       <td><input type="file" name="file" class="ed" id="file">
          </td>
            </tr> 
       <tr>
	        <td colspan="2" class="style8 style2 style9"><div align="center"><strong><font size="+1">Shona Choice</font></strong></div>
        </td>
	       </tr><tr>
  <td width="205"> <span class="style1 style9">Shona</span></td>
  <td width="225">
    <select name="shona"><option>L 1</option>
    <option>L 2</option>
    
    </select></td>
</tr>  
        <tr>
	        <td colspan="2" class="style8 style2 style9"><div align="center"><strong><font size="+1">Guardian Information</font></strong></div>
        </td>
	       </tr>   <tr>
            <td height="24">E mail</td>
            <td>
              <input name="email" type="text" size="30" id="email"   onblur="validateEmail(this);"/>            </td>
          </tr>
           
		  <tr>
            <td>Contact Number</td>
            <td>
              <input name="contact" type="text" size="30" id="contact" maxlength="12"  />            </td>
          </tr>
          <tr>
            <td>Contact Address</td>
            <td>
              <textarea name="address" cols="27" rows="2" id="address"></textarea>            </td>
          </tr>  
          <tr>
        <td>&nbsp;</td>
       <td><input class="mybutton" type="submit" value="Submit" id="button" name="submit"></td></tr>
           
	      
       
           
          </tr></td>                     
        </tbody>
      </table>
	 
</form>


</body></html>