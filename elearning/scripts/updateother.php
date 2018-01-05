	<script type='text/javascript' src='../JavaScriptSpellCheck/include.js' ></script>
	<script type='text/javascript'> $Spelling.SpellCheckAsYouType('remark')</script>
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
   <script type="text/javascript">
function LimtCharacters10(txtMsg, CharLength, indicator) {
chars = txtMsg.value.length;
document.getElementById(indicator).innerHTML = CharLength - chars;
if (chars > CharLength) {
txtMsg.value = txtMsg.value.substring(0, CharLength);
}
}
</script>
		<form action="" method="post" onSubmit="MM_validateForm('grade','','RinRange0:100');return document.MM_returnValue"><!--A....80% and above<br>B....between 70% and 79%<br>C....between 50% and 69%<br>U....49% and below-->


<br />
        <center><font><?php echo "You are updating remarks for student <strong>$_REQUEST[reg]</strong><br>subject <strong>$_REQUEST[subject]</strong>";
		 $a=' <tr>
    <td width="172">  Effort:</td>
    <td width="190"><select name="grade">
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
    <option value="F">F</option>
        </select></td>
  </tr>';
  ?></font><br>


        <table width="378" border="1">
        <?php if($_REQUEST['name']!="Extra_Mural_Actvites")
		echo $a;
		 ?>
 <tr>
    <td width="172">Subject Remarks:</td>
    <td width="190">Number of characters required 
        <label id="lblcount10" style="background-color:#E2EEF1;color:Red;font-weight:bold;">175</label><br/>
       <textarea name="remark" id="remark" rows="6" cols="85" onkeyup="LimtCharacters10(this,175,'lblcount10');" maxlength="175"><?php echo $_REQUEST['remark']; ?></textarea>
       	<input type="button" value="Spell Check" onclick="$Spelling.SpellCheckInWindow('remark')"></td>
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
	 function clean($str) {
                            $str = @trim($str);
                            if (get_magic_quotes_gpc()) {
                                $str = stripslashes($str);
                            }
                            return mysql_real_escape_string($str);
                        }
						$remarkz=clean($_POST['remark']);
 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		
		$class = $row1['name'];}
function qoutess($str){
$remove[] = "'";
$remove[] = '"';
$remove[] = "-"; // just as another example
$new = str_replace($remove, "", $str);
return $new;
}
$rem=qoutess($remarkz);

mysql_query("update results set mark='$_POST[grade]',effort='$_POST[grade]'
 where reg='$_REQUEST[reg]' and subject_id='other' and subject='$_REQUEST[name]' and session='$_SESSION[year]' and term='$_SESSION[term]' and level='$grd' and class='$class'") or die (mysql_error());
  $check = mysql_query("SELECT * FROM remarks where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_REQUEST[reg]' and subject_id = '$_REQUEST[name]' ")or die(mysql_query());
if( mysql_num_rows($check)==1)
 
mysql_query("update remarks set remark='$rem'
 where student='$_REQUEST[reg]' and subject_id='$_REQUEST[name]' and session='$_SESSION[year]' and term='$_SESSION[term]'") or die (mysql_error());
 if( mysql_num_rows($check)==0)
 mysql_query("insert into remarks (remark,student,subject_id,session,term,teacher) values('$rem','$_REQUEST[reg]','$_REQUEST[name]','$_SESSION[year]','$_SESSION[term]','$_SESSION[username]') ") or die (mysql_error());

?>
<script language="javascript">
 alert("Remarks updated");
  location = 'index.php?page=tab.php&reg=<?php echo $_GET['reg']; ?>&name=<?php echo $_GET['zita']; ?>&surname=<?php echo $_GET['surname']; ?>&level=<?php echo $_GET['level']; ?>#other'
  </script>
  
  <?php
    
 

   }
		?>