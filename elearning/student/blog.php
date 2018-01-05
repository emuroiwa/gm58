<?php
if(isset($_POST['Submits'])){

include 'opendb.php';
$date = date('d-m-Y h:s');
$rs = mysql_query("select * from student,entries where entries.user = student.reg group by entries.id desc");
while($row = mysql_fetch_array($rs)){
if($_POST['comment'.$row['id']] != ""){
	$rs1 = mysql_query("insert into comments(id,user,entry_id,date,comment) 	values('NULL','$_SESSION[reg]','".$_POST['id'.$row['id']]."','$date','".$_POST['comment'.$row['id']]."')");

if($rs)
{

}
}

else{

}
}
}
?>
<?php
if(isset($_POST['Submit'])){
session_start();
include 'opendb.php';
$date = date('d-m-Y h:s');
 $rs1 = mysql_query("select * from allocation where username = '$_SESSION[reg]'");
		while($rw = mysql_fetch_array($rs1))
		{
		$username = $rw['username'];
		}
$rs = mysql_query("insert into entries(id,user,entry,date_entered,publish) values('NULL','$_SESSION[reg]','$_POST[comment]','$date','$username')");

if($rs)
{

}
else{
echo "Error has occured";

}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="single_eight.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style3 {font-size: 12px; }
-->
</style>
<style type="text/css">
<!--
.style6 {font-size: 14px}
.style7 {
	font-size: 14px;
	font-weight: bold;
	color: #FF0000;
}
.style13 {color: #FFFFFF}
.style14 {
	color: #000000;
	font-weight: bold;
}
.style15 {color: #000000}
-->
</style>
</head>

<body>
<div class="content">
     <div class="content8">
              <div class="tit-blue">
               
                <p><strong>Student Forum Section</strong> </p>
                
          </div>
              
     </div>
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
          <form action="" method="post" >
          <table width="42%" align="center">
          <tr><td class="style15 style3">
        <p class="style15 style3" style="padding-right:10px;">
		 <?php
		 include 'opendb.php';
		
		
		 $rs = mysql_query("select * from student,entries where entries.user = student.reg and entries.publish = student.reg group by entries.id desc ");
		
		 
		
		 while($row = mysql_fetch_array($rs)){
		
		 echo "<b>".$row['name']." ".$row['surname']." ".$row['date_entered']."</b>"."<br>"." ".$row['entry']." ";
		 
		 
		
		 ?> 
         <p class="style15 style3" style="background:#CCCCCC;">
         <?php
         $rs1 = mysql_query("select * from student,comments where comments.entry_id = '$row[id]' and comments.user = student.reg group by comments.id desc LIMIT 2");
		 $rs4 = mysql_query("select * from comments where entry_id = '$row[id]'");
		 $parameter = mysql_num_rows($rs4);
		 while($rw = mysql_fetch_array($rs1)){
		 echo "<i><b>".$rw['name']." ".$rw['surname']." ".$rw['date']."</b></i>"."<br>"." ".$rw['comment']." <br>";
		 }
		  echo"<a href='index.php?page=viewall.php&id=$row[id]'>view all comments($parameter)</a>";
		 ?>
         </p>
		
         <input type='text' name='comment<?php echo $row['id']; ?>' id='comment' size='50' />
          <input type='hidden' name='id<?php echo $row['id']; ?>' id='id' value='<?php echo $row['id']; ?>'/>
          <input type='submit' name='Submits' id='Submits' value='Comment' class='btn'    onmouseover="hov(this,'btn btnhov')" onMouseOut="hov(this,'btn')" />
          <br><br />
		<?php
		 }
		
		 ?> </p></td></tr></table></form>
        

         
</div>
    </div>
</body>
</html>
