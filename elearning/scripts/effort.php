<?php
 $check=mysql_query("select * from results where reg='$_REQUEST[reg]' AND subject_id='$_REQUEST[subject]' AND subject='$_REQUEST[name]' and session='$_SESSION[year]' and term='$_SESSION[term]'") or die(mysql_error());
//results.php&name=Mechanical&subject=maths&reg=MCS146680T&surname=Muroiwa&zita=Ernest&level=7
$checkrw = mysql_num_rows($check);
   if($checkrw == 1){
   ?>
    <script language="javascript">
 alert(" ..................MARK ALREADY CAPTURED!!!!!!!!!!")
location = 'index.php?page=tab.php&reg=<?php echo $_GET['reg'];?>&level=<?php echo $_GET['level'];?>&name=<?php echo $_GET['zita'];?>&surname=<?php echo $_GET['surname'];?>#<?php echo $_GET['subject'];?>';
  </script>
  <?php
  exit;
   }
		?>
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
  
		<form action="" method="post" onSubmit="MM_validateForm('grade','','RinRange0:100');return document.MM_returnValue"><!--A....80% and above<br>B....between 70% and 79%<br>C....between 50% and 69%<br>U....49% and below-->


<br />
        <center>  <font><?php echo "You are updating results for student<strong> $_REQUEST[reg]</strong><br> For
 <strong>$_REQUEST[name] </strong>Subject<strong> $_REQUEST[subject] </strong>"; ?></font><br>

        <table width="378" border="1">
  <tr>
    <td width="172"><?php echo "  <strong>$_REQUEST[name]</strong>";?>  Effort:</td>
    <td width="190"><select name="grade">
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
    <option value="F">F</option>
        </select></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><label>
      <input type="submit" name="button" id="button" class="mybutton" value="Submit" />
    </label></td>
    </tr>
</table>
</form>
<?php
if(isset($_POST['button'])){
	 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
mysql_query("INSERT INTO results (reg,subject_id,subject,mark,effort,open,session,term,level,class)
VALUES
('$_REQUEST[reg]','$_REQUEST[subject]','$_REQUEST[name]','$_POST[grade]','$_POST[grade]','no','$_SESSION[year]','$_SESSION[term]','$grd','$class')") or die (mysql_error());
?>
<script language="javascript">
alert("Results Captured <?php echo "for $_REQUEST[name] with  $_POST[grade] for Effort "; ?>")
   location = 'index.php?page=tab.php&reg=<?php echo $_GET['reg'];?>&level=<?php echo $_GET['level'];?>&name=<?php echo $_GET['zita'];?>&surname=<?php echo $_GET['surname'];?>#<?php echo $_GET['subject'];?>'; 

  </script>
  <?php
   header("location: index.php?page=tab.php&reg=$_REQUEST[reg]&name=$_GET[zita]&surname=$_GET[surname]&level=$_GET[level]#$_GET[subject]"); 

	
   }
		?>