<center><br>
<strong><h3>Deassign class</h3> </strong>
<form action="" method="post"><table width="615" style="border:1px solid #000000">
  <tr>
    <td width="91">Username</td>
    <td width="148"><input name="ecnum" type="text" /></td><td width="49"><input name="Submit" class="mybutton" type="submit" value="Find" /></td>
    
  </tr>
  
</table>
</form>
<br>

								 
                                    
						
                      <?php
					  if(isset($_POST['Submit'])){
	 
	  
	  
	    $rs1 = mysql_query("select * from users where username = '$_POST[ecnum]'");
   $rw = mysql_num_rows($rs1);
   if($rw == 0){
   ?>
  <script language="javascript">
 alert("EC Number does not exist");
 location = 'index.php?page=deassclass.php'
  </script>
  <?php
  exit;
   }  $rs11 = mysql_query("select * from class where teacher = '$_POST[ecnum]'");
   $rw1 = mysql_num_rows($rs11);
   if($rw1 == 0){
   ?>
  <script language="javascript">
 alert("EC Number has not been assigned a class");
 location = 'index.php?page=deassclass.php'
  </script>
  <?php
  exit;
   }
   
     $rs1 = mysql_query("select * from users where username = '$_POST[ecnum]' and suspend ='0'");
   $rw = mysql_num_rows($rs1);
   if($rw == 1){
   ?>
  <script language="javascript">
 alert("This EC number has been suspended");
 location = 'index.php?page=deassclass.php'
  </script>
  <?php
  exit;
   }
	  
	
	   $rs1=mysql_query("select * from users where username='$_POST[ecnum]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$name = $row1['namee'];}
	  $rs=mysql_query("select * from users,class where username='$_POST[ecnum]' and teacher=username") or die(mysql_error());	
	  ?>
<table width="65%" border="1" bordercolor="#000000" style="border:1px solid #000000">
					  <tr> 
                                   <td bgcolor="#0066FF" width="80"><font color="#000000">DEASSIGN</font></td>
                                   <td bgcolor="#0066FF" width="80"><font color="#000000">Name</font></td>
                                   <td bgcolor="#0066FF" width="103"><font color="#000000">Surname</font></td>
                                   
                                   <td bgcolor="#0066FF" width="145"><font color="#000000">Class</font></td>
                                   <td bgcolor="#0066FF" width="145"><font color="#000000">Grade</font></td>
                                  <?php
while($row = mysql_fetch_array($rs)){
		//$name = $row['name'];
		$surname = $row['surname'];
		
		$class = $row['name'];
		$level= $row['level'];
		$id= $_POST['ecnum'];
		
	 echo "<tr><td width='45%'><a href='index.php?page=deassign2.php&id=$id' onclick='return confirm(\"Are you sure?\")'>[click to Deassign]</a></font></td><td>".$name."</td><td>".$surname."</td><td>".$class."</td><td>".$level."</td></tr>";
  
    
   }
	
}
?>        </tr></table></center>
 