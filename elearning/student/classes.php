 <?php

$rs=mysql_query("select * from student_class where student='$_SESSION[reg]' ") or die(mysql_error());
$rows=mysql_num_rows($rs);	if($rows==0)
 {
 	echo("<SCRIPT LANGUAGE='JavaScript'> window.alert('Not Registered Yet')
		  javascript:history.go(-1)
		 	</SCRIPT>");  
			exit;

 }
while($row = mysql_fetch_array($rs)){
		$level = $row['level'];
}

?>







<br>
<strong>Online Subjects for form <?php echo $level; ?></strong>
<form action="test.php" method="get"><table width="100%" border="0" style="border:1px solid #000000"  >
					  <tr> 
                                   <td bgcolor="#CCCCCC" width="647"><font color="#000000">Name</font></td>
                       
                        <td bgcolor="#CCCCCC" width="87"><font color="#000000">Form</font></td>
                        <td bgcolor="#CCCCCC" width="158"><font color="#000000">View</font></td>
  <?php
					  	 
	 
	  
	  $rs=mysql_query("select * from upload where user='$level' group by subject") or die(mysql_error());
while($row = mysql_fetch_array($rs)){
		$name = $row['subject'];
		
		//$level = $row['level'];
		/*$id = $row['id'];*/
		

echo "<tr><td>".$name."</font></td><td>".$level."</td><td><a href='index.php?page=notes.php&subject=$name&level=$level'>[View Material]</a></td></tr>";
}
?>        </tr></table>

 
 