
  
		<form action="" method="post" >


        <center><font><?php echo "You are updating results for student <strong>$_REQUEST[reg]</strong><br> For
<strong> $_REQUEST[name] </strong>CURRENT EFFORT IS <strong>$_REQUEST[mark] </strong> and subject <strong>$_REQUEST[subject]</strong>"; ?></font><br>


        <table width="378" border="1">
  <tr>
<td width="172">Subject Effort:</td>
    <td width="190"><select name="grade">
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
    <option value="F">F</option>
        </select></td>  </tr>
  <tr>
    <td colspan="2" align="center"><label>
      <input type="submit" name="button" id="button" class="mybutton" value="Submit" />
    </label></td>
    </tr>
</table>
</form>
<?php
if(isset($_POST['button'])){
	 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}


mysql_query("update results set mark='$_POST[grade]',effort='$_POST[grade]'
 where reg='$_REQUEST[reg]' and subject_id='$_REQUEST[subject]' and subject='$_REQUEST[name]' and session='$_SESSION[year]' and term='$_SESSION[term]' and level='$grd' and class='$class'") or die (mysql_error());
echo $grd;
?>

<script language="javascript">
 alert("Results updated <?php echo "for $_REQUEST[name]  "; ?>")
    location = 'index.php?page=tab.php&reg=<?php echo $_GET['reg']; ?>&name=<?php echo $_GET['zita']; ?>&surname=<?php echo $_GET['surname']; ?>&level=<?php echo $_GET['level']; ?>#<?php echo $_GET['subject']; ?>'
  </script>

  <?php
      header("location: index.php?page=tab.php&reg=$_REQUEST[reg]&name=$_GET[zita]&surname=$_GET[surname]&level=$_GET[level]#$_GET[subject]"); 

	
   }
		?>