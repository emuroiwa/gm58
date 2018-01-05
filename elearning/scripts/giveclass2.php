<?php
if(isset($_POST['button'])){
	 $date = date('m/d/Y'); 
	   $rs1 = mysql_query("select * from class where name= '$_POST[class]' and level ='$_POST[level]'");
   $rw = mysql_num_rows($rs1);
   if($rw == 1){
   echo"<font color='#FF0000'>  Grade $_POST[level] $_POST[class] has already been assigned</font> ";
  exit;
   }
	mysql_query("insert into class (name,level,teacher,date) values ('$_POST[class]','$_POST[level]','$_REQUEST[id]','$date')")or die(mysql_error());
	
	?>
    <script language="javascript">
 alert("Successful assignment");
 location = 'index.php'
  </script>
    <?php
}
?>
<br><center>
<strong>You are assigning a  class to Ec Number <?php echo $_REQUEST['id']; ?>.</strong>
<form method="post" action=""><center><table width="253" style="border:1px solid #000000">
  <tr>
    <td width="124">Class Type:</td>
    <td width="113"><select name="class"><option>Shona L1</option>
    <option>Shona L2</option>
    <option>Extra Mural Activities</option>
    <option>Computers</option>
    
    </select></td>
  </tr><tr>
  <td width="34%"> <span class="style1 style9">Grade</span></td>
  <td width="66%">
    <select name="level"><option>1</option>
    <option>2</option>
    <option>3</option><option>4</option>
    <option>5</option>
    <option>6</option>
       <option>7</option>
 
    </select></td>
</tr> 
  <tr>
    
    <td colspan="2"><input type="submit" name="button" value="Assign" id="button"></td>
  </tr>
</table>
</form></center>