<?php function st($year,$term)
{
	 $rs1=mysql_query("select * from student_class where student='$_GET[reg]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['class'];}
 $aanum = mysql_query("SELECT * FROM average where  session='$year' and term='$term'  and grade='$grd' ")or die(mysql_query());
  $rowsaa = mysql_num_rows($aanum);
  
   $aa = mysql_query("SELECT Sum(average) as n FROM average where session='$year' and term='$term'  and grade='$grd'  ")or die(mysql_query());
 while($aarw = mysql_fetch_array($aa, MYSQL_ASSOC)){
  $stravg=$aarw['n'];}
  $all_stravg=$stravg/$rowsaa;
  $all_stravg_rounded=round($all_stravg, 2);
return  $all_stravg_rounded;
}
function std($year,$term){
	$rs1=mysql_query("select * from student_class where student='$_GET[reg]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['class'];}
 $avgcheck = mysql_query("SELECT Sum(average) as n FROM average where session='$year' and term='$term'  and grade='$grd'  and student='$_GET[reg]' ")or die(mysql_query());
  
   $aanum = mysql_query("SELECT * FROM average where  session='$year' and term='$term'  and grade='$grd' and student='$_GET[reg]'  ")or die(mysql_query());
  $rowsaa = mysql_num_rows($aanum);
 while($rwavg = mysql_fetch_array($avgcheck, MYSQL_ASSOC)){
  $avgintable=$rwavg['n'];}
  $std=round($avgintable/$rowsaa,2);
  return $std;
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

<center><?php if(isset($_POST['overallsubmit'])){	
$sq="select * from remarks where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]' and subject_id='head' and remark='$_POST[remarks]'";
$rem=mysql_query($sq);
 $remarkrows = mysql_num_rows($rem);

if ($remarkrows==1){?>
<script language="javascript">
 alert("Remarks already captured...... Please Do Not Reload The Page Again")

  </script><?php
  	
}if ($remarkrows==0){
	mysql_query("INSERT INTO remarks (student,remark,session,term,date,subject_id)
VALUES
('$_GET[reg]','$_POST[remarks]','$_SESSION[year]','$_SESSION[term]','$date','HEAD')") or die (mysql_error());?>
<script language="javascript">
 alert("General Remarks captured")
 
  </script><?php
  header("location: head.php?page=head_tab.php&reg=$_GET[reg]&name=$_GET[name]&surname=$_GET[surname]&level=$_GET[level]&class=$_GET[class]&teacher=$_GET[teacher]#remark"); 

}
}

?><?php 
 
$sq="select * from remarks where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]' and subject_id='head'";
$rem=mysql_query($sq);

 $remarkrows = mysql_num_rows($rem);
if ($remarkrows==1){
while($row233=mysql_fetch_array($rem,MYSQL_ASSOC)){
	$link="<strong>Remarks Captured</strong><br>
$row233[remark]";}
		
		print "$link";?>
	 <style>
		#b
		{
		visibility:hidden;
		}
		</style><?php
}
?>
<div id="b"><form action="" method="post" onSubmit="MM_validateForm('remarks','','R');return document.MM_returnValue">
<center>To help with Head's Remark.<br>
<?php 
$avg=std($_SESSION['year'],$_SESSION['term']);
$savg=st($_SESSION['year'],$_SESSION['term']);

echo "$_GET[name] $_GET[surname]($_GET[reg])'s Overall average across all subjects was<strong> $avg% </strong> <br>
While Stream average was <strong>$savg%</strong>  ";?>
<table border="1" bordercolor="#000000">
 <tr>
       <td><span class="style12">Remarks</span></td>
       <td> <textarea name="remarks" id="remarks"></textarea><input type="button" value="Spell Check" onclick="$Spelling.SpellCheckInWindow('remarks')">
          </td>
            </tr> <tr><td  align="center"><input class="mybutton" type="submit" value="Submit" id="button" name="overallsubmit"></td></tr></table></form></div>

