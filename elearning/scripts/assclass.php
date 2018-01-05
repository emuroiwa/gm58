<br><center>
<strong><h3>Assign Class to teachers</h3></strong>
<form action="" method="post"><table width="615" style="border:1px solid #000000">
  <tr>
    <td width="91">Username</td>
    <td width="148"><input name="ecnum" type="text" /></td><td width="49"><input name="Submit" type="submit" value="Find" class="mybutton"/></td>
    
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
 location = 'index.php?page=assclass.php'
  </script>
  <?php
  exit;
   }   $rs1 = mysql_query("select * from class where teacher= '$_POST[ecnum]'");
   $rw = mysql_num_rows($rs1);
   if($rw == 1){
   echo"<font color='#FF0000'>  EC Number $_POST[ecnum] has already been assigned a class</font> ";
  exit;
   }
   
     $rs1 = mysql_query("select * from users where username = '$_POST[ecnum]' and suspend ='0'");
   $rw = mysql_num_rows($rs1);
   if($rw == 1){
   ?>
  <script language="javascript">
 alert("This EC number has been suspended");
 location = 'index.php?page=assclass.php'
  </script>
  <?php
  exit;
   }
	  
	
	  
	  $rs=mysql_query("select * from users where username='$_POST[ecnum]'") or die(mysql_error());	
	  ?>
<table width="65%" style="border:1px solid #000000" border="1" bordercolor="#000000" >
					  <tr> 
                                   <td bgcolor="#0066FF" width="80"><font color="#000000">ASSIGN</font></td>
                                   <td bgcolor="#0066FF" width="80"><font color="#000000">Name</font></td>
                                   <td bgcolor="#0066FF" width="103"><font color="#000000">Surname</font></td>
                                   
                                   <td bgcolor="#0066FF" width="145"><font color="#000000">National ID Number</font></td>
                                  
								 
<?php  
while($row = mysql_fetch_array($rs)){
		$name = $row['namee'];
		$surname = $row['surname'];
		
		$nationalid = $row['idnumber'];
		//$state= $row['state'];
		$id= $_POST['ecnum'];
		
	 echo "<tr><td><a href='index.php?page=giveclass.php&id=$id&name=$name&surname=$surname' onclick='return confirm(\"Are you sure?\")'>[click to assign]</a></font></td><td>".$name."</td><td>".$surname."</td><td>".$nationalid."</td></tr>";
  
    
   }
	
}
?>        </tr></table></center>
 