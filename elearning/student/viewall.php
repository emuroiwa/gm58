<?php
@session_start();
include 'aut.php';
?>
<?php
if(isset($_POST['Submits'])){
include 'opendb.php';
$date = date('d-m-Y m:h:s');
$rs = mysql_query("select * from student,entries where entries.user = student.reg ");
while($row = mysql_fetch_array($rs)){
if($_POST['comment'.$row['id']] != ""){
	$rs1 = mysql_query("insert into comments(id,user,entry_id,date,comment) 	values('NULL','$_SESSION[username]','".$_POST['id'.$row['id']]."','$date','".$_POST['comment'.$row['id']]."')");

if($rs)
{
?>
<script language="javascript">
location = 'index.php?page=viewall.php&id=<?php echo $_GET['id'] ?>'
</script>
<?php
}
}

else{

}
}
}
?>
<?php
if(isset($_POST['Submit'])){
include 'opendb.php';
$date = date('d-m-Y m:h:s');
$rs = mysql_query("insert into entries(id,user,entry,date_entered) values('NULL','$_SESSION[username]','$_POST[comment]','$date')");

if($rs)
{
?>
<script language="javascript">
alert("Your Post Successfully Uploaded");

</script>
<?php
}
else{
echo "Error has occured";

}
}
?>

<?php
include 'opendb.php';
$rs = mysql_query("select * from student where reg = '$_SESSION[reg]'");
while($row = mysql_fetch_array($rs))
{
$name = $row['name'];
$surname = $row['surname'];
$email = $row['email'];
$sex = $row['sex'];
}
?>

</head>

<body>

          <p><span class="style15 style3">Welcome to Regina Mundi College. Its a free blog that all registred members are free to take part and ear out their views.</span>
          <form action="" method="post" class="style15 style3">
            Post your Topic
              <label>
              <input type="text" name="comment" id="comment" size="50" />
              </label>
              <label>
              <input type="submit" name="Submit" id="Submit" value="Post" class="btn"    onmouseover="hov(this,'btn btnhov')" onMouseOut="hov(this,'btn')" />
            </label>
          </form>
          </p>
          <form action="" method="post">
          <div id= "comments">
          <table width="42%" align="center">
          <tr><td class="style15 style3">
        <p class="style15 style3" style="padding-right:10px;">
		 <?php
		 include 'opendb.php';
		
		 $rs = mysql_query("select * from student,entries where entries.id = '$_GET[id]' and entries.user = student.reg ");
		
		 while($row = mysql_fetch_array($rs)){
		 echo "<b>".$row['name']." ".$row['surname']." ".$row['date_entered']."</b>"."<br>"." ".$row['entry']." ";
		 
		 
		
		 ?> 
         <p class="style15 style3" style="background:#CCCCCC;">
         <?php
         $rs1 = mysql_query("select * from student,comments where comments.entry_id = '$row[id]' and comments.user = student.reg ");
		 $rs4 = mysql_query("select * from comments where entry_id = '$row[id]'");
		 $parameter = mysql_num_rows($rs4);
		 while($rw = mysql_fetch_array($rs1)){
		 echo "<i><b>".$rw['name']." ".$rw['surname']." ".$rw['date']."</b></i>"."<br>"." ".$rw['comment']." <br>";
		 }
		  
		 ?>
         </p>
		
         <input type='text' name='comment<?php echo $row['id']; ?>' id='comment' size='50' />
          <input type='hidden' name='id<?php echo $row['id']; ?>' id='id' value='<?php echo $row['id']; ?>'/>
          <input type='submit' name='Submits' id='Submits' value='Comment' class='btn'    onmouseover="hov(this,'btn btnhov')" onMouseOut="hov(this,'btn')" />
          <br><br />
		<?php
		 }
		 ?> </p></td></tr></table></form>

         
         </body>
</html>
