
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
        <center> <font><?php echo "You are updating results for student<strong> $_REQUEST[reg]</strong><br> For
 <strong>$_REQUEST[name] </strong>Subject<strong> $_REQUEST[subject] </strong>written on <strong>$_REQUEST[date]</strong>"; ?></font><br>

        <table width="378" border="1">
  <tr>
    <td width="172">Subject Percentage:</td>
    <td width="190"><input name="grade" type="text" id="grade" maxlength="3" /></td>
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
$c=$_POST['grade'];

mysql_query("INSERT INTO cw (reg,subject_id,subject,mark,description,date,term,session)
VALUES
('$_REQUEST[reg]','$_REQUEST[subject]','$_REQUEST[name]','$_POST[grade]','$_REQUEST[de]','$_REQUEST[date]','$_SESSION[term]','$_SESSION[year]')") or die (mysql_error());
?>
<script language="javascript">
 alert("Results updated <?php echo "for $_REQUEST[name] with $c%  "; ?>")
 location:history.go(-2)
  </script>
  <?php
   }
		?>