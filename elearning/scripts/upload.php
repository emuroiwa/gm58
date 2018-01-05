<center><?php if(isset($_POST['submit'])){
$fn = time().$_FILES['file']['name'];
		  	if(!move_uploaded_file($_FILES['file']['tmp_name'],"report/".$fn)){?>
        <script language="javascript">
		alert("report uploaded");
		
		</script>
        <?php
		exit;}
  
   else{
			
	mysql_query("INSERT INTO reports (reg,report,session,term,date)
VALUES
('$reg','$fn','$_SESSION[year]','$_SESSION[term]','$date')") or die (mysql_error());
   }}


  $r121 = mysql_query("SELECT * FROM results where  session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg' and reg not in(select reg from reports where term='$_SESSION[term]' and session='$_SESSION[year]' and reg='$reg') ")or die(mysql_query());
   $rows11 = mysql_num_rows($r121);
 if($rows11==16){?>
<div id="b"><form action="" method="post"  enctype="multipart/form-data" name="addroom"  >
<table border="1" bordercolor="#000000">
 <tr>
       <td><span class="style12">Upload Report (excel docu only)</span></td>
       <td><input type="file" name="file" class="ed" id="file">
          </td>
            </tr> <tr><td  align="center"><input class="mybutton" type="submit" value="Submit" id="button" name="submit"></td></tr></table></div></form>
<?php } else { echo "Upload of report will be open until all subjects are captured for $surname $name <br>
 

"; }
$sq="select * from reports where  session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$reg'";
$re=mysql_query($sq);

while($row2=mysql_fetch_array($re,MYSQL_ASSOC)){
	echo
 "<table border='1' bordercolordark='#0066FF'><tr><td>Student Number</td><td>Student</td><td>Delete<br />
</td></tr>";
		$r = $row2['reg'];
		$id= $row2['id'];
		$full=$name." ".$surname;
echo
 "<br>

 <tr><td>$r</td><td>$full</td><td><a href='index.php?page=delete.php&id=$id'>
<font  color='#FF0000'>Delete </font></a></td></tr></table>";
}
?></center>