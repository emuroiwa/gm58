 
	  <?php $rs=mysql_query("select * from users where access='customer' order by name asc,surname") or die(mysql_error());	
	  ?>
<center><h4>List of customer</h4><table width="97%" style="border:1px solid #000000" border="1" bordercolor="#000000" >
					  <tr> 
                                   
                                   <td bgcolor="white" width="37"><font color="#000000">Name</font></td>
                                   <td bgcolor="white" width="53"><font color="#000000">Surname</font></td>
                                    <td bgcolor="white" width="23"><font color="#000000">Sex</font></td>
                                     <td bgcolor="white" width="33"><font color="#000000">Email</font></td>
                                      <td bgcolor="white" width="187"><font color="#000000">Address</font></td>
                                  
								 
<?php  
while($row = mysql_fetch_array($rs)){
		$name = $row['name'];
		$surname = $row['surname'];
		
		$nationalid = $row['idnumber'];
		//$state= $row['state'];
			$class = $row['name'];
		$level= $row['level'];
		$id= $row['id'];
		

	 echo "<tr><td>".$name."</td><td>".$surname."</td><td>$row[sex]</td><td>$row[email]</td><td>$row[username]</td></tr>";
  
    
   }
	
?>        </tr></table></center>
 