<?php

//GETTING CLASS AVERAGE PER SUBJECT IN SUBJECT_ID MATHS

function classavg($x)
{
	 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
 $aanum = mysql_query("SELECT * FROM results where subject_id='maths' and subject='$x' and session='$_SESSION[year]' and term='$_SESSION[term]' and class='$class' and level='$grd'  ")or die(mysql_query());
  $rowsaa = mysql_num_rows($aanum);
  
   $aa = mysql_query("SELECT Sum(results.mark) as n FROM results where subject_id='maths' and subject='$x' and session='$_SESSION[year]' and term='$_SESSION[term]' and class='$class' and level='$grd'  ")or die(mysql_query());
 while($aarw = mysql_fetch_array($aa, MYSQL_ASSOC)){
  $mechanicalavg=$aarw['n'];}
  $mechanical_classavg=$mechanicalavg/$rowsaa;
  $mechanical_classavg_rounded=round($mechanical_classavg, 2);
return  $mechanical_classavg_rounded;
}
$mechanicalavg=classavg("mechanical");
$mentalavg=classavg("mental");
$problemsavg=classavg("problems");
$test1avg=classavg("test1");
$test2avg=classavg("test2");
$classmaths=round(($mechanicalavg+$mentalavg+$problemsavg+$test1avg+$test2avg)/5,2);
//end of class averaage ----------------------------------------------------------------------------------------------------

//GETTING STREAM AVERAGE PER SUBJECT IN SUBJECT_ID MATHS

function streamavg($y)
{
	 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
 $aanum = mysql_query("SELECT * FROM results where subject_id='maths' and subject='$y' and session='$_SESSION[year]' and term='$_SESSION[term]'  and level='$grd'  ")or die(mysql_query());
  $rowsaa = mysql_num_rows($aanum);
  
   $aa = mysql_query("SELECT Sum(results.mark) as n FROM results where subject_id='maths' and subject='$y' and session='$_SESSION[year]' and term='$_SESSION[term]'  and level='$grd'  ")or die(mysql_query());
 while($aarw = mysql_fetch_array($aa, MYSQL_ASSOC)){
  $stravg=$aarw['n'];}
  $all_stravg=$stravg/$rowsaa;
  $all_stravg_rounded=round($all_stravg, 2);
return  $all_stravg_rounded;
}
$mechanical_stream_avg=streamavg("mechanical");
$mental_stream_avg=streamavg("mental");
$problem_stream_avg=streamavg("problems");
$test1_stream_avg=streamavg("test1");
$test2_stream_avg=streamavg("test2");
$streamaths=round(($mechanical_stream_avg+$mental_stream_avg+$problem_stream_avg+$test1_stream_avg+$test2_stream_avg)/5, 2);
//end of class averaage ----------------------------------------------------------------------------------------------------

//getting maths marks from table--------------------------------------------------------------------------------------------
  function getmark($subjectyacho){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='maths' and subject='$subjectyacho' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$_GET[reg]' ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $mechanical=$rw1['mark'];} 
  return $mechanical;  
  }
  $mechanical=getmark("mechanical");
   $mental=getmark("mental");
    $problems=getmark("problems");
	 $test1=getmark("test1");
	  $test2=getmark("test2"); 
	  //getting marks number of rows----------------------------------------------------------------------------------
    function getmarkrows($subjectyacho){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='maths' and subject='$subjectyacho' and session='$_SESSION[year]' and term='$_SESSION[term]'  ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
  return $rows;  
  }
      function getmarkrow(){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='maths'  and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$_GET[reg]' ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
  return $rows;  
  }
	  //end of getting marks number of rows----------------------------------------------------------------------------------
  //average-----------------------------------------------------------------------------------------------------------------
      $sum = mysql_query("SELECT Sum(results.mark) AS sum FROM `results` WHERE results.reg = '$reg' AND
results.subject_id = 'maths' AND results.`session` = '$_SESSION[year]' AND  results.term = '$_SESSION[term]' ")or die(mysql_query());  
 while($rwsum = mysql_fetch_array($sum, MYSQL_ASSOC)){
  $tot=$rwsum['sum'];}
  $average=$tot/5;
     $averagee=round($average, 2);
	 
	 
  //$result1 will be used kuzvi line 192 ikoko
   $result1 = mysql_query("SELECT * FROM subjects where type not in(select subject from results where term='$_SESSION[term]' and session='$_SESSION[year]' and reg='$reg' and subject_id='maths') and subject='maths' ")or die(mysql_query());

   
    
   
   $avgcheck = mysql_query("SELECT * FROM average where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg' and subject_id = 'maths' ")or die(mysql_query());
   $avgnum = mysql_num_rows($avgcheck);
 while($rwavg = mysql_fetch_array($avgcheck, MYSQL_ASSOC)){
  $avgintable=$rwavg['average'];
  } if($avgnum==1){
	mysql_query("update average set average='$averagee' where
 session='$_SESSION[year]' and `term`='$_SESSION[term]' and student='$reg' and subject_id = 'maths'") or die (mysql_error());  
	  
  }if($avgnum==0){
	  
mysql_query("INSERT INTO average (student,subject_id,class,grade,average,session,term)
VALUES
('$reg','maths','$class','$grd','$averagee','$_SESSION[year]','$_SESSION[term]')") or die (mysql_error());
	  }// end of average-----------------------------------------------------------------------------------------------------
//get student position-----------------------------------------------------------------------------my best query eva yakaipa
mysql_query("SET @row=0");
$pos=mysql_query("SELECT student,pos,average FROM (SELECT @row := @row+1 AS pos,student,average FROM average  where
 session='$_SESSION[year]' and `term`='$_SESSION[term]'  and subject_id = 'maths' and grade = '$grd' and class = '$class' ORDER BY average DESC) as n WHERE student='$reg'");
  while($rowpos = mysql_fetch_array($pos, MYSQL_ASSOC)){
  $position=$rowpos['pos'];
  } if($averagee==100){$position=1;}
 //end of yakaipa-------------------------------------------------------------------------------------------------------  
 echo"<center>Students Average $averagee% Position For maths is<strong> $position </strong></center> <hr>";
 //capture marks--------------------------------------------------------------------------------------------------------
 $co=0;
  while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)){
$co++;
$subject=$row1['type'];

if(getmarkrows("mechanical")==0 or getmarkrows("mental")==0 or getmarkrows("problems")==0 or getmarkrows("test1")==0 or getmarkrows("test2")==0) {
print "<a href='index.php?page=results.php&name=$subject&subject=maths&reg=$reg&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'><p align='left'>$co) <strong>$subject</strong></a></p>
";}
}
 // interface for updating the caputuerd marks------------------------------------------------------------------------------
if(getmarkrow()>0){
	echo"<center><table border='1'  align='center'><tr bgcolor='#FFFFFF'><td><strong>Subject</strong></td><td><strong>Mark Captured</strong></td><td><strong>Class Average</strong></td><td><strong>Stream Average</strong></td><td><strong>Click To Edit</strong></td><tr>";
function edit($title,$name,$subject_id,$mark,$class,$stream){
	  $t = mysql_query("SELECT * FROM class ,final ,student_class WHERE class.teacher = final.ecnumber AND student_class.`level` = class.`level` AND class.`name` = student_class.class AND student_class.student = '$_GET[reg]' and final.term='$_SESSION[term]'and final.year='$_SESSION[year]' ")or die(mysql_query());
   $order = mysql_num_rows($t);
   //check if stuent needs corrections
   $corrections=mysql_query("select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]' and status='pending'" );


 $correctionrows = mysql_num_rows($corrections);
   //if ORDER FINALIZED
   if($order==11 && $correctionrows==0){
	 
	   	$a= "<tr><td><strong>$title</strong></td><td bgcolor='#FFFFFF'>$mark%</td><td>$class%</td><td>$stream%</td><td>ORDER FINALIZED</td></tr>";
	      } else{
	$a= "<tr><td><strong>$title</strong></td><td bgcolor='#FFFFFF'>$mark%</td><td>$class%</td><td>$stream%</td><td><a href='index.php?page=updateresults.php&name=$name&subject=$subject_id&reg=$_GET[reg]&mark=$mark&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'>[ edit ]</a></td></tr>

";}return $a;
	}
	 if(getmarkrows("mechanical")==1){print edit('Mechanical','mechanical','maths',$mechanical,$mechanicalavg,$mechanical_stream_avg);}
	 if(getmarkrows("mental")==1){print edit('Mental','mental','maths',$mental,$mentalavg,$mental_stream_avg);}
	 if(getmarkrows("problems")==1){print edit('Problems','problems','maths',$problems,$problemsavg,$problem_stream_avg);}
	 if(getmarkrows("test1")==1){print edit('Test1','test1','maths',$test1,$test1avg,$test1_stream_avg);}
	 if(getmarkrows("test2")==1){print edit('Test2','test2','maths',$test2,$test2avg,$test2_stream_avg);}
echo"<tr><td><strong>Averages</strong></td><td bgcolor='#FFFFFF'>$averagee%</td><td>$classmaths%</td><td>$streamaths%</td><td></td><tr></table>";

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
function LimtCharacters(txtMsg, CharLength, indicator) {
chars = txtMsg.value.length;
document.getElementById(indicator).innerHTML = CharLength - chars;
if (chars > CharLength) {
txtMsg.value = txtMsg.value.substring(0, CharLength);
}
}
</script>
<center><?php if(isset($_POST['mathsbutton'])){	
  function clean($str) {
                            $str = @trim($str);
                            if (get_magic_quotes_gpc()) {
                                $str = stripslashes($str);
                            }
                            return mysql_real_escape_string($str);
                        }
						function qoutes22($str){
$remove[] = "'";
$remove[] = '"';
$remove[] = "-"; // just as another example
$new = str_replace($remove, "", $str);
return $new;
}
						$remarkz=clean($_POST['remark']);
						$remarkz2=qoutes22($remarkz);
$sq="select * from remarks where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg' and subject_id='maths' and remark='$remarkz2'";
$rem=mysql_query($sq);
 $remarkrows = mysql_num_rows($rem);

if ($remarkrows==1){?>
<script language="javascript">
 alert("Remarks already captured . Please Do Not Reload The Page Again")

  </script><?php
  	
}if ($remarkrows==0){
	mysql_query("INSERT INTO remarks (student,remark,session,term,date,subject_id,teacher)
VALUES
('$reg','$remarkz2','$_SESSION[year]','$_SESSION[term]','$date','maths','$_SESSION[username]')") or die (mysql_error());?>
<script language="javascript">
 alert("Remarks updated");
  location = 'index.php?page=tab.php&reg=<?php echo $_GET['reg']; ?>&name=<?php echo $_GET['name']; ?>&surname=<?php echo $_GET['surname']; ?>&level=<?php echo $_GET['level']; ?>#maths'  
  </script><?php
      header("location: index.php?page=tab.php&reg=$_REQUEST[reg]&name=$_GET[name]&surname=$_GET[surname]&level=$_GET[level]#english"); 

}
}

  $r121 = mysql_query("SELECT * FROM results where  session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' and subject_id='maths' and reg not in(select student from remarks where term='$_SESSION[term]' and session='$_SESSION[year]' and student='$reg' and subject_id='maths') ")or die(mysql_query());
   $rows11 = mysql_num_rows($r121);
  // echo $rows11;
 if($rows11==5){?>
<form action="" method="post" onSubmit="MM_validateForm('remark','','R');return document.MM_returnValue">
<table border="1" bordercolor="#000000">
 <tr>
       <td><span class="style12">Remarks</span></td>
       <td>Number of characters required 
        <label id="lblcount" style="background-color:#E2EEF1;color:Red;font-weight:bold;">355</label><br/>
       <textarea name="remark" id="remark" rows="8" cols="85" onkeyup="LimtCharacters(this,355,'lblcount');" maxlength="355"></textarea>
       	<input type="button" value="Spell Check" onclick="$Spelling.SpellCheckInWindow('remark')">
          </td>
            </tr> <tr><td  align="center"><input class="mybutton" type="submit" value="Submit" id="button" name="mathsbutton"></td></tr></table></form>
<?php } 
$sq="select * from remarks where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$reg' and subject_id='maths'";
$rem=mysql_query($sq);
 $remarkrows = mysql_num_rows($rem);
 $t = mysql_query("SELECT * FROM class ,final ,student_class WHERE class.teacher = final.ecnumber AND student_class.`level` = class.`level` AND class.`name` = student_class.class AND student_class.student = '$_GET[reg]' and final.term='$_SESSION[term]'and final.year='$_SESSION[year]' ")or die(mysql_query());
   $order = mysql_num_rows($t);
   $corrections=mysql_query("select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]'  and status='pending'" );


 $correctionrows = mysql_num_rows($corrections);
if ($remarkrows==1){
while($row233=mysql_fetch_array($rem,MYSQL_ASSOC)){
	 //if ORDER FINALIZED
   if($order==11 && $correctionrows==0){$link="<strong>Comments Captured</strong> :$row233[remark]<br>
<a href='index.php?page=updateremarks.php&reg=$reg&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&subject=maths&remark=$row233[remark]'>*** REMARKS CAPTURED  [ edit ]*** </a>";}else{$link="<strong>Comments Captured</strong> :$row233[remark]<br>
<a href='index.php?page=updateremarks.php&reg=$reg&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]&subject=maths&remark=$row233[remark]'>*** REMARKS CAPTURED  [ edit ]*** </a>";}
		
		print "$link";
}
}
}
//END of REMARKS----------------------------------------------------------------------------------------------------------


?></center>

 