<?php
 
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='art' and subject='art' and session='$_SESSION[year]' and term='$_SESSION[term]' ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
  while($rwavg = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $art=$rwavg['mark'];
  } 
  

  if($rows==1){?>
<style>
		#b
		{
		visibility:hidden;
		}
		</style><?php
	echo"<center><table border='1'  align='center'><tr bgcolor='#FFFFFF'><td><strong>Subject</strong></td><td><strong>Effort Captured</strong></td><td><strong>Click To Edit</strong></td></tr>
	<tr><td><strong>Art</strong></td><td bgcolor='#FFFFFF'>$art</td><td><a href='index.php?page=updateart.php&name=art&subject=art&reg=$reg&mark=$art&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'>[ edit ]</a></td></tr></table>

";

?>
<style>
		#b
		{
		visibility:hidden;
		}
		</style><?php
}
		?>
 <div id="b">
  
		<form action="" method="post" ><!--A....80% and above<br>B....between 70% and 79%<br>C....between 50% and 69%<br>U....49% and below-->


<br />
        <center>  <font><?php echo "You are updating results for student<strong> $_REQUEST[reg]</strong><br> For
 <strong>Art/Craft </strong>"; ?></font><br>

        <table width="378" border="1">
  <tr>
    <td width="172">Effort:</td>
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
</form></div>
<?php
if(isset($_POST['button'])){	
 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='art' and subject='art' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$_GET[reg]' ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
  while($rwavg = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $art=$rwavg['mark'];
  } 
  
  if($rows==1){
	 ?>
<script language="javascript">
 alert("Results Already Captured ")
   location = 'index.php?page=tab.php&reg=<?php echo $_GET['reg'];?>&level=<?php echo $_GET['level'];?>&name=<?php echo $_GET['zita'];?>&surname=<?php echo $_GET['surname'];?>#art';
</script>

  <?php
 exit;
	  }
	
	 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}

mysql_query("INSERT INTO results (reg,subject_id,subject,mark,effort,open,session,term,level,class)
VALUES
('$_REQUEST[reg]','art','art','$_POST[grade]','$_POST[grade]','no','$_SESSION[year]','$_SESSION[term]','$grd','$class')") or die (mysql_error());
?>
<script language="javascript">
 alert("Results Captured <?php echo "with $_POST[grade] for Effort "; ?>")
   location = 'index.php?page=tab.php&reg=<?php echo $_GET['reg'];?>&level=<?php echo $_GET['level'];?>&name=<?php echo $_GET['zita'];?>&surname=<?php echo $_GET['surname'];?>#art';
</script>

  <?php
  // header("location: index.php?page=tab.php&reg=$_GET[reg]&name=$_GET[zita]&surname=$_GET[surame]&level=$_GET[level]#$_REQUEST[name]"); 
   }
		?>