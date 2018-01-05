

<?php
error_reporting(0);
	 include 'opendb.php';
		if(isset($_POST['Search'])){
		$item=$_POST['user'];
		$result = mysql_query("select * from student where username = '$item' and suspend = '0'");
		$rw = mysql_num_rows($result);
		if($rw == 0){
		 echo("<SCRIPT LANGUAGE='JavaScript'> window.alert('Either User is already unsuspended or Doesnt Exit')
		location = 'index.php?page=unsuspend_std.php'
		 	</SCRIPT>"); 
			exit();
		}
		
		else
		{
		while($row = mysql_fetch_array($result)){
		$name = $row['name'];
		$surname = $row['surname'];
		$id = $row['id'];
		$idnumber = $row['idnumber'];
		}
		
		}
}
?>
<?php  
if(isset($_POST['Submit'])){
 include 'opendb.php';
      	  $result ="";
		 $userid= $_POST['userid'];
	   
		    $rez = mysql_query("Update student set suspend = '1' where id = '$userid'") or die(mysql_error());
		
							 

			 if ($rez )
			    {
				  echo("<SCRIPT LANGUAGE='JavaScript'> window.alert('User $_POST[name] $_POST[surname] unsuspended')
		location = 'index.php?page=unsuspend_std.php'
		 	</SCRIPT>"); 
			exit; 
				 }
			 else
			  {
			      $msg= "Error occured";
		}
			   
}
?>
<div align="center"><br />
 <font color="black" size="+1"><strong>Enter STUDENT NUMBER of the student you want to unsuspend and then confirm with the details below<br /></strong></font>
</div>
<form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1" onsubmit="MM_validateForm('value','','R');return document.MM_returnValue">
				    <center>
				    <table width="400" border="0"  align="center">
    <tr><div align="left"> <font face="Verdana, Arial, Helvetica, sans-serif" ><font color="#0000FF"><b><?php if ($result ) { echo $msg;}?></b></font></font></div></tr>
      <tr>
        <td width="277"><table width="399" border="0">
		  <tr>
            <td width="165">Student Number</td>
            <td width="224">
              <input name="user" type="text" size="30" id="value"    />
              <input type="submit" name="Search" value="Find" /></td>
          </tr>
        </table></td>
      </tr>
    </table>
  </form>
                    <font color="black" size="+1"><strong>Unsuspension Confirmation Details</strong></font>
                    <form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1" onsubmit="MM_validateForm('userid','','R','name','','R','surname','','R','idnumber','','R');return document.MM_returnValue">
    <table width="400" border="0"  align="center">
    <tr><div align="left"> <font face="Verdana, Arial, Helvetica, sans-serif" ><font color="#0000FF"><b><?php if ($result ) { echo $msg;}?></b></font></font></div></tr>
      <tr>
        <td width="277"><table width="399" border="0">
		<tr>
            <td width="165">User ID</td>
            <td width="224">
            <input name="userid" type="text" size="30" id="userid" readonly value="<?php echo $id ?>"  />            </td>
          </tr>
          <tr>
            <td width="165">Name</td>
            <td width="224">
              <input name="name" type="text" size="30" id="name" readonly value="<?php echo $name ?>"  />             </td>
          </tr>
		  <tr>
            <td width="165"> Surname </td>
            <td width="224">
            <input name="surname" type="text" size="30" id="surname" readonly value="<?php echo $surname ?>"  />            </td>
          </tr>
		  <tr>
            <td width="165">ID Number</td>
            <td width="224">
            <input name="idnumber" type="text" size="30" id="idnumber" readonly value="<?php echo $idnumber ?>"  />            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="UnSuspend" /></td>
          </tr>
        </table></td>
      </tr>
    </table>
  </form>