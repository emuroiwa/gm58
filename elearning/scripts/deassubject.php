<br>
<strong>DE-assign Subjects to teachers</strong>
<form action="" method="post"><table width="615" border="0" style="border:1px solid #000000">
  <tr>
    <td width="91">EC Number</td>
    <td width="148"><input name="ecnum" type="text" /></td><td width="49"><input name="Submit" type="submit" value="Find" /></td>
    
  </tr>
  
</table>
</form>
<br>

<table width="65%" border="0" style="border:1px solid #000000" >
					  <tr> 
                                   <td bgcolor="#0066FF" width="80"><font color="#000000">DEASSIGN</font></td>
                                   <td bgcolor="#0066FF" width="80"><font color="#000000">Name</font></td>
                                   <td bgcolor="#0066FF" width="103"><font color="#000000">Surname</font></td>
                                   
                                   <td bgcolor="#0066FF" width="145"><font color="#000000">Subject</font></td>
                                   <td bgcolor="#0066FF" width="145"><font color="#000000">Form</font></td>
                                  
								 
                                    
						
                      <?php
					  if(isset($_POST['Submit'])){
	 
	  
	  
	    $rs1 = mysql_query("select * from users where username = '$_POST[ecnum]'");
   $rw = mysql_num_rows($rs1);
   if($rw == 0){
   ?>
  <script language="javascript">
 alert("EC Number does not exist");
 javascript:history.go(-1)  </script>
  <?php
  exit;
   }
   
     $rs1 = mysql_query("select * from users where username = '$_POST[ecnum]' and suspend ='0'");
   $rw = mysql_num_rows($rs1);
   if($rw == 1){
   ?>
  <script language="javascript">
 alert("This EC number has been suspended");
 javascript:history.go(-1)  </script>
  <?php
  exit;
   }
	  $rs11 = mysql_query("select * from subjects where teacher = '$_POST[ecnum]'");
   $rw1 = mysql_num_rows($rs11);
   if($rw1 == 0){
   ?>
  <script language="javascript">
 alert("EC Number has been assigned");
 javascript:history.go(-1)
  </script>
  <?php
  exit;
   }
    
	
	  
	  $rs=mysql_query("select * from users,subjects where username='$_POST[ecnum]' and teacher=username") or die(mysql_error());	  
while($row = mysql_fetch_array($rs)){
		$name = $row['namee'];
		$surname = $row['surname'];
		
		$subject = $row['subject'];
		$level= $row['level'];
		$id= $_POST['ecnum'];
		
	 echo "<tr><td><a href='index.php?page=deassign.php&id=$id'>[click to Deassign]</a></font></td><td>".$name."</td><td>".$surname."</td><td>".$subject."</td><td>".$level."</td></tr>";
  
    
   }
	
}
?>        </tr></table>
 