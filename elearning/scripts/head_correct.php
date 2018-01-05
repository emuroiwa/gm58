<script type='text/javascript' src='../JavaScriptSpellCheck/include.js' ></script>
	<script type='text/javascript'>$Spelling.SpellCheckAsYouType('corrections')</script>
	
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

<center><?php if(isset($_POST['correctsubmit'])){	
$sq="select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]' and subject_id='head' and remark='$_POST[remarks]'";
$rem=mysql_query($sq);
 $remarkrows = mysql_num_rows($rem);

if ($remarkrows==1){?>
<script language="javascript">
 alert("Remarks already captured...... Please Do Not Reload The Page Again")

  </script><?php
  	
}if ($remarkrows==0){
	mysql_query("INSERT INTO correct (ecnumber,student,remark,session,term,date,subject_id)
VALUES
('$_GET[teacher]','$_GET[reg]','$_POST[corrections]','$_SESSION[year]','$_SESSION[term]','$date','HEAD')") or die (mysql_error());?>
<script language="javascript">
 alert("General Remarks captured")
 
  </script><?php
  header("location: head.php?page=head_tab.php&reg=$_GET[reg]&name=$_GET[name]&surname=$_GET[surname]&level=$_GET[level]&class=$_GET[class]&teacher=$_GET[teacher]#correct"); 

}
}

?><?php 
 
$sq="select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and student='$_GET[reg]' and subject_id='head' and status='pending'";
$rem=mysql_query($sq);

 $remarkrows = mysql_num_rows($rem);
if ($remarkrows>0){
	echo"Corrections to be made for $_GET[name] $_GET[surname]($_GET[reg])";
	}$a=0;
while($row233=mysql_fetch_array($rem,MYSQL_ASSOC)){
	$a++;
	$link="<br>$a)
 <strong>$row233[remark]</strong><br>";
		
		print " $link";?>
	 <style>
		#b
		{
		visibility:hidden;
		}
		</style><?php
}
?>
<form action="" method="post" onSubmit="MM_validateForm('corrections','','R');return document.MM_returnValue">
<table border="1" bordercolor="#000000">
 <tr>
       <td><span class="style12">Description</span></td>
       <td> <textarea name="corrections" id="corrections"></textarea><input type="button" value="Spell Check" onclick="$Spelling.SpellCheckInWindow('corrections')">
          </td>
            </tr> <tr><td  align="center"><input class="mybutton" type="submit" value="Submit" id="button" name="correctsubmit"></td></tr></table></form>

