<?php $ta = mysql_query("SELECT * FROM class ,final ,student_class WHERE class.teacher = final.ecnumber AND student_class.`level` = class.`level` AND class.`name` = student_class.class AND student_class.student = '$_GET[reg]' and final.term='$_SESSION[term]'and final.year='$_SESSION[year]' ")or die(mysql_query());
   if( mysql_num_rows($ta)==1){ 
   include 'headremark.php';
   }
   ?><script type='text/javascript' src='../JavaScriptSpellCheck/include.js' ></script>
	<script type='text/javascript'>$Spelling.SpellCheckAsYouType('remarks')</script>

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
function LimtCharacters4(txtMsg, CharLength, indicator) {
chars = txtMsg.value.length;
document.getElementById(indicator).innerHTML = CharLength - chars;
if (chars > CharLength) {
txtMsg.value = txtMsg.value.substring(0, CharLength);
}
}
</script>
<center><?php if(isset($_POST['overallsubmit'])){	
 function clean3($str) {
                            $str = @trim($str);
                            if (get_magic_quotes_gpc()) {
                                $str = stripslashes($str);
                            }
                            return mysql_real_escape_string($str);
                        }
						$remarkz=clean3($_POST['remarks']);
$sq="select * from remarks where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg' and subject_id='overall' and remark='$remarkz'";
$rem=mysql_query($sq);
 $remarkrows = mysql_num_rows($rem);

if ($remarkrows==1){?>
<script language="javascript">
 alert("Remarks already captured...... Please Do Not Reload The Page Again")

  </script><?php
  	
}if ($remarkrows==0){
	mysql_query("INSERT INTO remarks (student,remark,session,term,date,subject_id,teacher)
VALUES
('$reg','$remarkz','$_SESSION[year]','$_SESSION[term]','$date','OVERALL','$_SESSION[username]')") or die (mysql_error());?>
<script language="javascript">


  location = 'index.php?page=tab.php&reg=<?php echo $_GET['reg']; ?>&name=<?php echo $_GET['name']; ?>&surname=<?php echo $_GET['surname']; ?>&level=<?php echo $_GET['level']; ?>#overall'  
  </script><?php
  header("location: index.php?page=tab.php&reg=$reg&name=$name&surname=$surname&level=$_GET[level]#overall"); 

}
}

  $r121 = mysql_query("SELECT * FROM results where  session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' and reg not in(select student from remarks where term='$_SESSION[term]' and session='$_SESSION[year]' and student='$reg' and subject_id='overall') ")or die(mysql_query());
   $rows11 = mysql_num_rows($r121);
 //echo $rows11;
 // exit;
 if($rows11==32){?>
<form action="" method="post" onSubmit="MM_validateForm('remarks','','R');return document.MM_returnValue">
<table border="1" bordercolor="#000000">
 <tr>
       <td><span class="style12">General Remarks</span></td>
       <td>Number of characters required 
        <label id="lblcount4" style="background-color:#E2EEF1;color:Red;font-weight:bold;">800</label><br/>
       <textarea name="remarks" id="remarks" rows="10" cols="85" onkeyup="LimtCharacters4(this,800,'lblcount4');" maxlength="800s"></textarea>
       	<input type="button" value="Spell Check" onclick="$Spelling.SpellCheckInWindow('remarks')">
          </td>
            </tr> <tr><td  align="center"><input class="mybutton" type="submit" value="Submit" id="button" name="overallsubmit"></td></tr></table></form>
<?php } 
 
$sq="select * from remarks where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg' and subject_id='overall'";
$rem=mysql_query($sq);
$t = mysql_query("SELECT * FROM class ,final ,student_class WHERE class.teacher = final.ecnumber AND student_class.`level` = class.`level` AND class.`name` = student_class.class AND student_class.student = '$_GET[reg]' and final.term='$_SESSION[term]'and final.year='$_SESSION[year]' ")or die(mysql_query());
   $order = mysql_num_rows($t); //check if stuent needs corrections
   $corrections=mysql_query("select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]'  and status='pending'" );


 $correctionrows = mysql_num_rows($corrections);
 $remarkrows = mysql_num_rows($rem);
if ($remarkrows==1){
while($row233=mysql_fetch_array($rem,MYSQL_ASSOC)){
	
		
   //if ORDER FINALIZED
   if($order==1 && $correctionrows==0){$link="<strong>General Remarks Captured</strong> :$row233[remark]<br><a href='index.php?page=updateremarks.php&reg=$reg&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&subject=overall&remark=$row233[remark]'> ***[ edit ]*** </a>
";}
		
		else{$link="$row233[remark] <br>
<a href='index.php?page=updateremarks.php&reg=$reg&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&subject=overall&remark=$row233[remark]'>  ***[ edit ]***</a><br><br>";}
		
		print "$link";?>
	 <style>
		#b
		{
		visibility:hidden;
		}
		</style><?php
}
}?>
</center>