 
	  <?php $rs=mysql_query("select * from users,class where teacher=username order by level,name asc,surname") or die(mysql_error());	
	  ?>
<center><h4>List of staff members</h4><table width="65%" style="border:1px solid #000000" border="1" bordercolor="#000000" >
					  <tr> 
                                   
                                   <td bgcolor="#0066FF" width="80"><font color="#000000">Name</font></td>
                                   <td bgcolor="#0066FF" width="103"><font color="#000000">Surname</font></td>
                                   
                                   <td bgcolor="#0066FF" width="145"><font color="#000000">National ID Number</font></td>
                                   <td bgcolor="#0066FF" width="80"><font color="#000000">Class</font></td>
                                  <td bgcolor="#0066FF" width="120"><font color="red">DELETE</font></td>
								 
<?php  
while($row = mysql_fetch_array($rs)){
		$name = $row['namee'];
		$surname = $row['surname'];
		
		$nationalid = $row['idnumber'];
		//$state= $row['state'];
			$class = $row['name'];
		$level= $row['level'];
		$id= $row['username'];
		
	 echo "<tr><td>".$name."</td><td>".$surname."</td><td>".$nationalid."</td><td>".$level.$class."</td><td><a href='index.php?page=delete.php&id=$id' onclick='return confirm(\"Are you sure?\")'>[click to delete]</a></font></td></tr>";
  
    
   }
	
?>        </tr></table></center>
 