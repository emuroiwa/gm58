<?php
$stand=$_GET['id'];


$r1 = mysql_query("SELECT * FROM stand where id_stand='$stand'")or die(mysql_query());
   $rows = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $price=$rw1['price']; 
  $purchasedate=$rw1['datestatus']; 
  $instalments=$rw1['instalments'];
  $vat=$rw1['vat'];
  $vatdate=$rw1['vatdate'];
  $deposit=$rw1['deposit'];$standno=$rw1['number'];
  }
  //Deposit so far
 $r = mysql_query("SELECT Sum(payment.cash) AS tot FROM payment where stand='$stand' and d='Stand Deposit'")or die(mysql_query());
    while($rw = mysql_fetch_array($r, MYSQL_ASSOC)){
  $deposit_so_far=$rw['tot']; 
 } 
/* echo $deposit_so_far; echo $deposit;
 if($deposit_so_far!=$deposit){
	 echo "sdfu";
	 }
exit; */ 	




 
$lastmonth=lastmonth($stand);
$lastcash=lastcash($stand,lastmonth($stand));
  echo "Stand # <strong> $standno</strong>
<br>Instalments is <strong>$ $instalments</strong> Monthly<br>

Deposit paid <strong>$ $deposit</strong>";
echo "<font color='#CC0000'> Last Payment Month is $lastmonth<br>
Amount $ $lastcash</font>";


//processing forme
if(isset($_POST['Submit'])){
		$stand=$_GET['id'];
	
$balance=clean($_POST['amount']);
$instalment=clean($_POST['instalment']);
 //debit
    mysql_query("INSERT INTO `interestpayment` (`cash`, `stand`, `date`, `capturer`, `month`, `year`, `payment_type`, `d`, `payment_date`, `value_date`, `description`) VALUES ('$balance', '$stand', NOW(), '$_SESSION[name]', '$lastmonth', '$NumberOfMonths', 'Credit','Balance_After_VAT', now(), '$month','$_POST[txtDescription]')") or die (mysql_error());
	//Write to log file
			 WriteToLog("Interest Payment Amount=$balance |Stand = $standno",$_SESSION['username']);
					   	msg('Payment Was  Successfull');
			 link1("index.php?page=NewPayment.php&id=$stand"); 
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
</script> <!-- Include Core Datepicker Stylesheet -->
<link rel="stylesheet" href="ui.datepicker.css" type="text/css" media="screen" title="core css file" charset="utf-8" />


<!-- Include jQuery -->
<script src="jquery.js" type="text/javascript" charset="utf-8"></script>

<!-- Include Core Datepicker JavaScript -->
<script src="ui.full_datepicker.js" type="text/javascript" charset="utf-8"></script>

<!-- Attach the datepicker to dateinput after document is ready -->
<script type="text/javascript" charset="utf-8">
jQuery(function($){
$("#date").datepicker();
});
jQuery(function($){
$("#date1").datepicker();
});
</script>

<form action="" method="post" name="qualification_form"  >
<center>

<table width="50%" border="0" align="center" style="border-bottom:3px solid #000000;" bgcolor="#FFFFFF">
 
 
      <tr>
        <td><div align="center"><span class="style7"><strong>Process Payment</strong></span></div></td>
       
      </tr>
      
  </table> 
    <div class="errstyle" id="errr"></div>
    <div class="errstyle" id="err"></div>
 <table width="100%">
</table>

  
  <table width="50%" align="center" bgcolor="#FFFFFF">
<tr>
  <td width="109"> <span class="style1 style9">Interest :</span></td>
  <td width="150">
   $ <input type="text" name="amount" id="amount" value="<?php echo $instalments ;?>"  required /></td>
</tr><!-- <tr>
  <td width="109"> <span class="style1 style9">Instalment:</span></td>
  <td width="150">
   $ <input type="number" name="instalment" id="instalment" value="<?php echo $instalments ;?>" required /></td>
</tr> --><tr>
  <td width="109"> <span class="style1 style9">Payment Date :</span></td>
  <td width="150">
    <input type="text" name="date1" id="date1" value="<?php echo $date;?>"  required/></td>
</tr>
          
</td></tr>

<tr><td colspan="2"  align="center"><div align="center">
  <input type="submit" name="Submit" size="30" class="btn btn-info" onclick="return confirm('Are you sure you want to UPDATE  Informantion ?')" value="Save"/>
</div></td>
</tr>
</table>
</form>
<div align="center">
  <?php 
$qry=mysql_query("select * from owners,clients,stand where owners.stand_id='$_REQUEST[id]' and clients.id=client_id and id_stand=owners.stand_id")or die(mysql_error());
while($info=mysql_fetch_array($qry)){	
?>
  <hr>
  <strong>Owner Details.</strong>

<table border="0" width="50%">
  <tr><td><strong>Owner Name</strong></td><td><?php echo $info['name']." ".$info['surname']; ?></td></tr>
<tr><td><strong>Contact Number</strong></td><td><?php echo $info['contact']; ?></td></tr>
<tr><td><strong>Address</strong></td><td><?php echo $info['address']; ?></td></tr>
<tr><td><strong>Email</strong></td><td><?php echo $info['email']; ?></td></tr>
<tr><td><strong>Date Of Birth</strong></td><td><?php echo $info['dob']; ?></td></tr>
</table></div>
<?php
}
?>