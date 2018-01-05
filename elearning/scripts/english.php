<?php
//GETTING CLASS AVERAGE PER SUBJECT IN SUBJECT_ID English
include 'englishfunction.php';
$spellingavg=classavgg("spelling");
$dictationavg=classavgg("dictation");
$languageavg=classavgg("language");
$comprehensionavg=classavgg("comprehension");
$test1avg=classavgg("test1");
$test2avg=classavgg("test2");
$classenglish=round(($spellingavg+$dictationavg+$languageavg+$comprehensionavg+$test1avg+$test2avg)/6, 2);
//end of class averaage ----------------------------------------------------------------------------------------------------

//GETTING STREAM AVERAGE PER SUBJECT IN SUBJECT_ID MATHS


$spelling_stream_avg=streamavgg("spelling");
$dictation_stream_avg=streamavgg("dictation");
$language_stream_avg=streamavgg("language");
$comprehension_stream_avg=streamavgg("comprehension");
$test1_stream_avg=streamavgg("test1");
$test2_stream_avg=streamavgg("test2");
$streamenglish=round(($spelling_stream_avg+$dictation_stream_avg+$language_stream_avg+$comprehension_stream_avg+$test1_stream_avg+$test2_stream_avg)/6, 2);

//end of class averaage ----------------------------------------------------------------------------------------------------

//getting english marks from table--------------------------------------------------------------------------------------------

  $spelling=getmarkk("spelling");
   $dictation=getmarkk("dictation");
    $language=getmarkk("language");
    $comprehension=getmarkk("comprehension");
	 $test1=getmarkk("test1");
	  $test2=getmarkk("test2"); 
	  $writting=getmarkk("writting");
	 $reading=getmarkk("reading");
	  $hand_writting=getmarkk("hand_writting"); 
	  //getting marks number of rows----------------------------------------------------------------------------------
    
	  //end of getting marks number of rows----------------------------------------------------------------------------------
  //average-----------------------------------------------------------------------------------------------------------------
      $sum = mysql_query("SELECT Sum(results.mark) AS sum FROM `results` WHERE results.reg = '$reg' AND
results.subject_id = 'english' AND results.`session` = '$_SESSION[year]' AND  results.term = '$_SESSION[term]' ")or die(mysql_query());  
 while($rwsum = mysql_fetch_array($sum, MYSQL_ASSOC)){
  $tot=$rwsum['sum'];}
  $average=$tot/6;
  //$result1 will be used kuzvi line 192 ikoko
   $averagee=round($average, 2);   
   $avgcheck = mysql_query("SELECT * FROM average where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg' and subject_id = 'english' ")or die(mysql_query());
   $avgnum = mysql_num_rows($avgcheck);
 while($rwavg = mysql_fetch_array($avgcheck, MYSQL_ASSOC)){
  $avgintable=$rwavg['average'];
  } if($avgnum==1){
	mysql_query("update average set average='$averagee' where
 session='$_SESSION[year]' and `term`='$_SESSION[term]' and student='$reg' and subject_id = 'english'") or die (mysql_error());  
	  
  }if($avgnum==0){
	  
mysql_query("INSERT INTO average (student,subject_id,class,grade,average,session,term)
VALUES
('$reg','english','$class','$grd','$averagee','$_SESSION[year]','$_SESSION[term]')") or die (mysql_error());
	  }// end of average-----------------------------------------------------------------------------------------------------
//get student position-----------------------------------------------------------------------------my best query eva yakaipa
mysql_query("SET @row=0");
$pos=mysql_query("SELECT student,pos,average FROM (SELECT @row := @row+1 AS pos,student,average FROM average  where
 session='$_SESSION[year]' and `term`='$_SESSION[term]'  and subject_id = 'english' and grade = '$grd' and class = '$class' ORDER BY average DESC) as n WHERE student='$reg'");
  while($rowpos = mysql_fetch_array($pos, MYSQL_ASSOC)){
  $position=$rowpos['pos'];
  } if($averagee==100){$position=1;}
 //end of yakaipa-------------------------------------------------------------------------------------------------------  
 echo"<center>Students Average $averagee% Position For English is <strong>$position</strong> </center> <hr>";
 
 //capture marks--------------------------------------------------------------------------------------------------------  
  $result1 = mysql_query("SELECT * FROM subjects where type not in(select subject from results where term='$_SESSION[term]' and session='$_SESSION[year]' and reg='$reg'  and subject_id='english') and subject='english' and type!='writting' and type!='hand_writting' and type!='reading' ")or die(mysql_query());

 $co=0;
  while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)){
$co++;
$subject=$row1['type'];
if(getmarkrowss("spelling")==0 or getmarkrowss("dictation")==0 or getmarkrowss("comprehension")==0 or getmarkrowss("language")==0 or getmarkrowss("test1")==0 or getmarkrowss("test2")==0) {
print "<a href='index.php?page=results.php&name=$subject&subject=english&reg=$reg&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'><p align='left'>$co) <strong>$subject</strong></a></p>
";}}
 $result12 = mysql_query("SELECT * FROM subjects where type not in(select subject from results where term='$_SESSION[term]' and session='$_SESSION[year]' and reg='$reg'  and subject_id='english') and subject='english'  and type!='spelling' and type!='dictation' and type!='comprehension' and type!='language' and type!='test1'  and type!='test2' ")or die(mysql_query());

  while($row12 = mysql_fetch_array($result12, MYSQL_ASSOC)){
$co++;
$subject=$row12['type'];
if( getmarkrowss("writting")==0 or getmarkrowss("reading")==0 or getmarkrowss("hand_writting")==0 ) {
print "<a href='index.php?page=effort.php&name=$subject&subject=english&reg=$reg&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'><p align='left'>$co) <strong>$subject</strong></a></p>
";}
}//-------------------------------------------------------------------------------------------------

 // interface for updating the caputuerd marks------------------------------------------------------------------------------
if(getmarkroww()>0){
	echo"<center><table border='1'  align='center'><tr bgcolor='#FFFFFF'><td><strong>Subject</strong></td><td><strong>Mark Captured</strong></td><td><strong>Class Average</strong></td><td><strong>Stream Average</strong></td><td><strong>Click To Edit</strong></td><tr>";
	function edit2($title,$name,$subject_id,$mark,$class,$stream){  $t = mysql_query("SELECT * FROM class ,final ,student_class WHERE class.teacher = final.ecnumber AND student_class.`level` = class.`level` AND class.`name` = student_class.class AND student_class.student = '$_GET[reg]' and final.term='$_SESSION[term]'and final.year='$_SESSION[year]' ")or die(mysql_query());
   $order = mysql_num_rows($t);
   
   //check if stuent needs corrections
   $corrections=mysql_query("select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]'   and status='pending'" );


 $correctionrows = mysql_num_rows($corrections);
   //if ORDER FINALIZED
   if($order==11 && $correctionrows==0){
	 
	   	$a= "<tr><td><strong>$title</strong></td><td bgcolor='#FFFFFF'>$mark%</td><td>$class%</td><td>$stream%</td><td>ORDER FINALIZED</td></tr>";
	      } else{
	$a= "<tr><td><strong>$title</strong></td><td bgcolor='#FFFFFF'>$mark</td><td>$class</td><td>$stream</td><td><a href='index.php?page=updateeffort.php&name=$name&subject=$subject_id&reg=$_GET[reg]&mark=$mark&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'>[ edit ]</a></td></tr>

";}
	return $a;
	}
	 if(getmarkrowss("spelling")==1){print edit('Spelling','spelling','english',$spelling,$spellingavg,$spelling_stream_avg);}
	 if(getmarkrowss("dictation")==1){print edit('Dictation','dictation','english',$dictation,$dictationavg,$dictation_stream_avg);}
	 if(getmarkrowss("comprehension")==1){print edit('Comprehension','comprehension','english',$comprehension,$comprehensionavg,$comprehension_stream_avg);}	
	  if(getmarkrowss("language")==1){print edit('Language','language','english',$language,$languageavg,$language_stream_avg);}
	 if(getmarkrowss("test1")==1){print edit('Test1','test1','english',$test1,$test1avg,$test1_stream_avg);}
	 if(getmarkrowss("test2")==1){print edit('Test2','test2','english',$test2,$test2avg,$test2_stream_avg);}
	 if(getmarkrowss("writting")==1){print edit2('Written English','writting','english',$writting,'--','--');}
	 if(getmarkrowss("reading")==1){print edit2('Reading','reading','english',$reading,'--','--');}
	 if(getmarkrowss("hand_writting")==1){print edit2('Hand Writting','hand_writting','english',$hand_writting,'--','--');}
	 
echo"<tr><td><strong>Averages</strong></td><td bgcolor='#FFFFFF'>$averagee%</td><td>$classenglish%</td><td>$streamenglish%</td><td></td><tr></table>";

//REMARKS html form and php mysql script-------------------------------------------------------------------------------------
?>

	<script type='text/javascript' src='../JavaScriptSpellCheck/include.js' ></script>
	<script type='text/javascript'>$Spelling.SpellCheckAsYouType('remark')</script>
	
	
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
function LimtCharacters1(txtMsg, CharLength, indicator) {
chars = txtMsg.value.length;
document.getElementById(indicator).innerHTML = CharLength - chars;
if (chars > CharLength) {
txtMsg.value = txtMsg.value.substring(0, CharLength);
}
}
</script>
<center><?php if(isset($_POST['engsubmit'])){	
 function clean1($str) {
                            $str = @trim($str);
                            if (get_magic_quotes_gpc()) {
                                $str = stripslashes($str);
                            }
                            return mysql_real_escape_string($str);
                        }
						function qoutes1($str){
$remove[] = "'";
$remove[] = '"';
$remove[] = "-"; // just as another example
$new = str_replace($remove, "", $str);
return $new;
}
						$remarkz=clean1($_POST['remark']);
						$remarkz2=qoutes1($remarkz);
$sq="select * from remarks where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg' and subject_id='english'";
$rem=mysql_query($sq);
 $remarkrows = mysql_num_rows($rem);
if ($remarkrows==1){?>
<script language="javascript">
 alert("Remarks already captured . Please Do Not Reload The Page Again")


  </script><?php	
}if ($remarkrows==0){
	mysql_query("INSERT INTO remarks (student,remark,session,term,date,subject_id,teacher)
VALUES
('$reg','$remarkz2','$_SESSION[year]','$_SESSION[term]','$date','english','$_SESSION[username]')") or die (mysql_error());?>
<script language="javascript">
 alert("Remarks updated");
  location = 'index.php?page=tab.php&reg=<?php echo $_GET['reg']; ?>&name=<?php echo $_GET['name']; ?>&surname=<?php echo $_GET['surname']; ?>&level=<?php echo $_GET['level']; ?>#english'  
  </script><?php
    header("location: index.php?page=tab.php&reg=$_REQUEST[reg]&name=$_GET[name]&surname=$_GET[surname]&level=$_GET[level]#english"); 

}
}

  $r121 = mysql_query("SELECT * FROM results where  session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' and subject_id='english' and reg not in(select student from remarks where term='$_SESSION[term]' and session='$_SESSION[year]' and student='$reg' and subject_id='english') ")or die(mysql_query());
   $rows11 = mysql_num_rows($r121);
 if($rows11==9){?>
<form action="" method="post" onSubmit="MM_validateForm('remark','','R');return document.MM_returnValue">
<table border="1" bordercolor="#000000">
 <tr>
       <td><span class="style12">Remarks</span></td>
       <td>Number of characters required 
        <label id="lblcount1" style="background-color:#E2EEF1;color:Red;font-weight:bold;">775</label><br/>
       <textarea name="remark" id="remark" rows="10" cols="85" onkeyup="LimtCharacters1(this,775,'lblcount1');" maxlength="775"></textarea>
       	<input type="button" value="Spell Check" onclick="$Spelling.SpellCheckInWindow('remark')">
          </td>
            </tr> <tr><td  align="center"><input class="mybutton" type="submit" value="Submit" id="button" name="engsubmit"></td></tr></table></form>
<?php } 
$sq="select * from remarks where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg' and subject_id='english'";
$rem=mysql_query($sq);
 $remarkrows = mysql_num_rows($rem);
 $t = mysql_query("SELECT * FROM class ,final ,student_class WHERE class.teacher = final.ecnumber AND student_class.`level` = class.`level` AND class.`name` = student_class.class AND student_class.student = '$_GET[reg]' and final.term='$_SESSION[term]'and final.year='$_SESSION[year]' ")or die(mysql_query());
 
   $order = mysql_num_rows($t);   
   $corrections=mysql_query("select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]'  and status='pending'" );


 $correctionrows = mysql_num_rows($corrections);
if ($remarkrows==1){
while($row233=mysql_fetch_array($rem,MYSQL_ASSOC)){
   if($order==1 && $correctionrows==0){
$link="<strong>Comments Captured</strong> :$row233[remark]<br>
<a href='index.php?page=updateng.php&reg=$reg&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&subject=english&remark=$row233[remark]'>*** REMARKS CAPTURED  [ edit ]*** </a>";}else{$link="<strong>Comments Captured</strong> :$row233[remark]<br><a href='index.php?page=updateng.php&reg=$reg&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&subject=english&remark=$row233[remark]'>*** REMARKS CAPTURED  [ edit ]*** </a><br><br>";}
		
		print "$link";
}
}
}
//END of REMARKS----------------------------------------------------------------------------------------------------------


?></center>

 