<?php
//end of class averaage ----------------------------------------------------------------------------------------------------

//getting content marks from table--------------------------------------------------------------------------------------------
  function getmark1($subjectyacho){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='content' and subject='$subjectyacho' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$_GET[reg]' ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $scripture=$rw1['mark'];} 
  return $scripture;  
  }
  $scripture=getmark1("scripture");
   $science=getmark1("science");
    $social_studies=getmark1("social_studies");

	  //getting marks number of rows----------------------------------------------------------------------------------
    function getmarkrows1($subjectyacho){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='content' and subject='$subjectyacho' and session='$_SESSION[year]' and term='$_SESSION[term]'  ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
  return $rows;  
  }
      function getmarkrow1(){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='content'  and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$_GET[reg]' ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
  return $rows;  
  }
	  //end of getting marks number of rows----------------------------------------------------------------------------------
  
  //$result1 will be used kuzvi line 192 ikoko
   $result1 = mysql_query("SELECT * FROM subjects where type not in(select subject from results where term='$_SESSION[term]' and session='$_SESSION[year]' and reg='$reg' and subject_id='content') and subject='content' ")or die(mysql_query());
  
    
 
 //end of yakaipa-------------------------------------------------------------------------------------------------------  
 //echo"<center>Students Average $averagee% Position For content is $position </center> <hr>";
 //capture marks--------------------------------------------------------------------------------------------------------
 $co=0;
  while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)){
$co++;
$subject=$row1['type'];

if(getmarkrows1("scripture")==0 or getmarkrows1("science")==0 or getmarkrows1("social_studies")==0 ) {
print "<a href='index.php?page=effort.php&name=$subject&subject=content&reg=$reg&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'><p align='left'>$co) <strong>$subject</strong></a></p>
";}
}
 // interface for updating the caputuerd marks------------------------------------------------------------------------------  
 $t = mysql_query("SELECT * FROM class ,final ,student_class WHERE class.teacher = final.ecnumber AND student_class.`level` = class.`level` AND class.`name` = student_class.class AND student_class.student = '$_GET[reg]' and final.term='$_SESSION[term]'and final.year='$_SESSION[year]' ")or die(mysql_query());
   $order = mysql_num_rows($t); //check if stuent needs corrections
   $corrections=mysql_query("select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]'  and status='pending'" );


 $correctionrows = mysql_num_rows($corrections);	   if($order==11 && $correctionrows==0){
	  // $status='ORDER FINALIZED';
	   	$a= "<tr><td><strong>Scripture</strong></td><td bgcolor='#FFFFFF'>$scripture</td><td>ORDER FINALIZED</td></tr>";
	   	$b= "<tr><td><strong>Science</strong></td><td bgcolor='#FFFFFF'>$science</td><td>ORDER FINALIZED</td></tr>";
			   	$c= "<tr><td><strong>Social Studies</strong></td><td bgcolor='#FFFFFF'>$social_studies</td><td>ORDER FINALIZED</td></tr>";	   	
				


	      } else{
	$a= "<tr><td><strong>Scripture</strong></td><td bgcolor='#FFFFFF'>$scripture</td><td><a href='index.php?page=updateeffort.php&name=scripture&subject=content&reg=$reg&mark=$scripture&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'>[ edit ]</a></td></tr>

";
$b="<tr><td><strong>Science</strong></td><td bgcolor='#FFFFFF'>$science</td><td><a href='index.php?page=updateeffort.php&name=science&subject=content&reg=$reg&mark=$science&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'>[ edit ]</a></td></tr>

";
$c="<tr><td><strong>Social Studies</strong></td><td bgcolor='#FFFFFF'>$social_studies</td><td><a href='index.php?page=updateeffort.php&name=social_studies&subject=content&reg=$reg&mark=$social_studies&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'>[ edit ]</a></td></tr>

";


}
if(getmarkrow1()>0){
	echo"<center><table border='1'  align='center'><tr bgcolor='#FFFFFF'><td><strong>Subject</strong></td><td><strong>Mark Captured</strong></td><td><strong>Click To Edit</strong></td><tr>";
	
	
 if(getmarkrows1("scripture")==1){print "$a";}
	 if(getmarkrows1("science")==1){print "$b";}
 if(getmarkrows1("social_studies")==1){print "$c";}

echo"</table>";

//REMARKS html form and php mysql script-------------------------------------------------------------------------------------
?>
<script type='text/javascript' src='../JavaScriptSpellCheck/include.js' ></script>
	<script type='text/javascript'>$Spelling.SpellCheckAsYouType('myTextArea')</script>
	
	

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
function LimtCharacters2(txtMsg, CharLength, indicator) {
chars = txtMsg.value.length;
document.getElementById(indicator).innerHTML = CharLength - chars;
if (chars > CharLength) {
txtMsg.value = txtMsg.value.substring(0, CharLength);
}
}
</script>
<center><?php if(isset($_POST['submit'])){
	 function clean2($str) {
                            $str = @trim($str);
                            if (get_magic_quotes_gpc()) {
                                $str = stripslashes($str);
                            }
                            return mysql_real_escape_string($str);
                        }
						function qoutes2($str){
$remove[] = "'";
$remove[] = '"';
$remove[] = "-"; // just as another example
$new = str_replace($remove, "", $str);
return $new;
}
						$remarkz=clean2($_POST['remark']);
							$remarkz2=qoutes2($remarkz);
	
$sq="select * from remarks where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg' and subject_id='content' and remark='$remarkz'";
$rem=mysql_query($sq);
 $remarkrows = mysql_num_rows($rem);

if ($remarkrows==1){?>
<script language="javascript">
 alert("Remarks already captured . Please Do Not Reload The Page Again")

  </script><?php
  	
}if ($remarkrows==0){
	mysql_query("INSERT INTO remarks (student,remark,session,term,date,subject_id,teacher)
VALUES
('$reg','$remarkz2','$_SESSION[year]','$_SESSION[term]','$date','content','$_SESSION[username]')") or die (mysql_error());?>
<script language="javascript">
 alert("Remarks updated");
  location = 'index.php?page=tab.php&reg=<?php echo $_GET['reg']; ?>&name=<?php echo $_GET['name']; ?>&surname=<?php echo $_GET['surname']; ?>&level=<?php echo $_GET['level']; ?>#content'  

  </script><?php
   header("location: index.php?page=tab.php&reg=$_REQUEST[reg]&name=$_GET[name]&surname=$_GET[surname]&level=$_GET[level]#content"); 
}
}

  $r121 = mysql_query("SELECT * FROM results where  session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' and subject_id='content' and reg not in(select student from remarks where term='$_SESSION[term]' and session='$_SESSION[year]' and student='$reg' and subject_id='content') ")or die(mysql_query());
   $rows11 = mysql_num_rows($r121);
   
 if($rows11==3){?>
<form action="" method="post">
<table border="1" bordercolor="#000000">
 <tr>
       <td><span class="style12">Remarks</span></td>
       <td>Number of characters required 
        <label id="lblcount2" style="background-color:#E2EEF1;color:Red;font-weight:bold;">175</label><br/>
       <textarea name="remark" id="remark" rows="6" cols="85" onkeyup="LimtCharacters2(this,175,'lblcount2');" maxlength="175"></textarea>
       	<input type="button" value="Spell Check" onclick="$Spelling.SpellCheckInWindow('remark')">
          </td>
            </tr> <tr><td  align="center"><input class="mybutton" type="submit" value="Submit" id="button" name="submit"></td></tr></table></form>
<?php } 
$sq="select * from remarks where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg' and subject_id='content'";
$rem=mysql_query($sq);
 $remarkrows = mysql_num_rows($rem);
  $t = mysql_query("SELECT * FROM class ,final ,student_class WHERE class.teacher = final.ecnumber AND student_class.`level` = class.`level` AND class.`name` = student_class.class AND student_class.student = '$_GET[reg]' and final.term='$_SESSION[term]'and final.year='$_SESSION[year]' ")or die(mysql_query());
   $order = mysql_num_rows($t); //check if stuent needs corrections
   $corrections=mysql_query("select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]'  and status='pending'" );


 $correctionrows = mysql_num_rows($corrections);
   //if ORDER FINALIZED
if ($remarkrows==1){
while($row233=mysql_fetch_array($rem,MYSQL_ASSOC)){
	
		
		   if($order==11 && $correctionrows==0){
$link="<strong>Comments Captured</strong> :$row233[remark]";}else{$link="<strong>Comments Captured</strong> :$row233[remark]<br>
<a href='index.php?page=updateremarks.php&reg=$reg&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&subject=content&remark=$row233[remark]'>*** REMARKS CAPTURED  [ edit ]*** </a><br><br>";}
		
		print "$link";
}
}
}
//END of REMARKS----------------------------------------------------------------------------------------------------------


?></center>

 