<?php
function clean($str) {
                            $str = @trim($str);
                            if (get_magic_quotes_gpc()) {
                                $str = stripslashes($str);
                            }
                            return mysql_real_escape_string($str);
                        }
							function qoutess($str){
$remove[] = "'";
$remove[] = '"';
$remove[] = "-"; // just as another example
$new = str_replace($remove, "", $str);
return $new;
}
if(isset($_POST['Login']))
	{
	include 'opendb.php';
	 if(strlen($_POST['password']) < 8 ){
   ?>
  <script language="javascript">
 alert("Password should be above 8 characters");
 javascript:history.go(-1)
  </script>
  <?php
  exit;
   } if(strlen($_POST['password2']) < 8 ){
   ?>
  <script language="javascript">
 alert("Password should be above 8 characters");
  javascript:history.go(-1)
  </script>
  <?php
  exit;
   }
   if($_POST['password']!=$_POST['password2']){
   ?>
  <script language="javascript">
 alert("Password did not match with confrim password");
 javascript:history.go(-1)
  </script>
  <?php
  exit;
   }else{
	   $pwd=clean($_POST['password']);
	   $reg=clean($_POST['regnum']);
	$rs = mysql_query("update student set password ='$pwd' where reg='$reg'") or die(mysql_error());
	echo("<SCRIPT LANGUAGE='JavaScript'> window.alert('SUCESS! Registration Complete')
		location = 'index.php'
		 	</SCRIPT>"); 
			exit;
	}
	}
?>

<?php
	if(isset($_POST['Save']))// button referencing
	{
				$reg2=clean(qoutess($_POST['regnum']));
		$dob=$_POST["day"]."/".$_POST["month"]."/".$_POST["year"] ;
		$r = mysql_query("select * from student where reg = '$_POST[regnum]' and password !='default' and status='ENROLLED'");
		if($w = mysql_fetch_array($r))
		{
		echo("<SCRIPT LANGUAGE='JavaScript'> window.alert('NOTICE! ACCOUNT ALREADY OPENED')
		 javascript:history.go(-1)
		 	</SCRIPT>"); 
			exit;
		}
		else
		{
		$rs = mysql_query("select * from student where reg = '$reg2' and status='ENROLLED'");
		if($row = mysql_fetch_array($rs))
		{
		$res = mysql_query("select * from student where id = '$row[id]' and dob = '$dob' and status='ENROLLED'");
		if($rw = mysql_fetch_array($res))
			{
		?>
        <style>
		#b
		{
		visibility:hidden;
		}
		</style>
        <center><br>
<br>
<br>
<br>
<br>
<br>
<br>
<form action="" method="post">
        
          <table width="50%" border="0" align="center">
  <tr>
    <td width="27%">Student #</td>
    <td width="73%"><input type="text" name="regnum" id="regnum" readonly size="25" value="<?php echo $row['reg']; ?>" /></td>
    </tr>
  <tr>
    <td>Password</td>
    <td><input type="password" name="password" id="password" placeholder="Must be more than 8 characters  "  size="25" /></td>
    </tr>
  <tr><tr>
    <td>Confirm Password</td>
    <td><input type="password" name="password2" placeholder="Must be more than 8 characters  " id="password2" size="25" /></td>
    </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="Login" id="Login" value="Save" class="art-button" style="zoom: 1;" />
    </div></td>
    </tr>
</table>

        
        </form></center>
        <?php
			}
			else
				{
		echo("<SCRIPT LANGUAGE='JavaScript'> window.alert('ERROR! Data miss match')
		 javascript:history.go(-1)
		 	</SCRIPT>"); 
			exit;
				}
		}
		else
		{
		echo("<SCRIPT LANGUAGE='JavaScript'> window.alert('ERROR! Student number doesnt exit')
		 javascript:history.go(-1)
		 	</SCRIPT>"); 
			exit;
		}
	}
	}
?>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-style: italic;
}
.style2 {
	color: #FF0000;
	font-weight: bold;
}
.style4 {color: #000000}
.style6 {color: #000000; font-size: 12px; }
-->
</style>
<div id="b"><br>
<br>
<br>
<br>
<br>
<center>
<form action="" method="post" name="form1">
  <p align="center">Please enter the pupil's DOB and registration number to create your account</p>
  <table width="76%" border="0" align="center">
    <tr>
	  <td width="32%" nowrap="nowrap">Date of birth</td>
	  <td width="68%" nowrap="nowrap"> <select name="day" id="day">
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
      <td>Student Number</td>
      <td><label>
        <input type="text" name="regnum" id="regnum" size="25" maxlength="10">
      </label></td>
    </tr>
  
    <tr>
      <td colspan="2"><label>
        <div align="center">
          <input type="submit" name="Save" id="Save" value="Proceed>>>>"  class="art-button" style="zoom: 1;">
          </div>
      </label></td>
    </tr>
  </table>
</form></center><br>
<br>
<br>
<br>


<br>
<br>

</div>
