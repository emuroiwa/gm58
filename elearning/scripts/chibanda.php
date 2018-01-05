<?php
include 'opendb.php';
 
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='habits' and subject='habits' and session='$_SESSION[year]' and term='$_SESSION[term]'  ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
  while($rwavg = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $art=$rwavg['mark'];
  } 
 // echo $rows;
	
	  function get($subjectyacho){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='habits' and subject='$subjectyacho' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$_GET[reg]' ")or die(mysql_query());
  
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $mechanical=$rw1['mark'];} 
  return $mechanical;  
  }
/*  $directions=get("directions");
   $improve=get("improve");
    $independent=get("independent");
	 $time=get("time");
	  $concentrate=get("concentrate"); 
	   $homework=get("homework"); */
  if($rows>0){
	echo"<center><table border='1'  align='center'><tr bgcolor='#FFFFFF'><td><strong>Subject</strong></td><td><strong>Effort Captured</strong></td><td><strong>Click To Edit</strong></td></tr>
	<tr><td><strong>Art</strong></td><td bgcolor='#FFFFFF'>$art</td><td><a href='index.php?page=updateart.php&name=art&subject=art&reg=$reg&mark=$art&surname=$_REQUEST[surname]&zita=$_REQUEST[name]&level=$_REQUEST[level]'>[ edit ]</a></td></tr></table>

";

?>
<style>
		#b
		{
		visibility:hidden;
		}
		</style><?php
}else{
		?>
        <style>
		#b
		{
		visibility: visible;
		}
		</style>
 <div id="b">
  
		<form action="" method="post" ><!--A....80% and above<br>B....between 70% and 79%<br>C....between 50% and 69%<br>U....49% and below-->


<br />
        <center>  <font><?php echo "You are updating results for student<strong> $_REQUEST[reg]</strong><br> For
 <strong>Art/Craft </strong>"; ?></font><br>

        <table width="342" border="1">
  <tr>
    <td width="262"><strong>WORK AND SOCIAL HABITS</strong></td>
    <td width="64"><strong>EFFORT</strong></td>
  </tr> <tr>
    <td width="262">Follows Directions</td>
    <td width="64"><select name="directions">
    <option value="10">Very Good</option>
    <option value="8">Good</option>
    <option value="6">Average</option>
    <option value="4">Poor</option>
    <option value="2">Very Poor</option>
        </select></td>
  </tr> <tr>
    <td width="262">Strives to Improve</td>
    <td width="64"><select name="improve">
    <option value="10">Very Good</option>
    <option value="8">Good</option>
    <option value="6">Average</option>
    <option value="4">Poor</option>
    <option value="2">Very Poor</option>
        </select></td>
  </tr><tr>
    <td width="262">Works Independently</td>
    <td width="64"><select name="independent">
    <option value="10">Very Good</option>
    <option value="8">Good</option>
    <option value="6">Average</option>
    <option value="4">Poor</option>
    <option value="2">Very Poor</option>
        </select></td>
  </tr><tr>
    <td width="262">Makes good use of Time</td>
    <td width="64"><select name="time">
    <option value="10">Very Good</option>
    <option value="8">Good</option>
    <option value="6">Average</option>
    <option value="4">Poor</option>
    <option value="2">Very Poor</option>
        </select></td>
  </tr>
  <tr>
    <td>Ability to concentrate</td>
    <td><select name="concentrate">
    <option value="10">Very Good</option>
    <option value="8">Good</option>
    <option value="6">Average</option>
    <option value="4">Poor</option>
    <option value="2">Very Poor</option>
        </select></td>
  </tr><tr>
    <td>Homework</td>
    <td><select name="homework">
    <option value="10">Very Good</option>
    <option value="8">Good</option>
    <option value="6">Average</option>
    <option value="4">Poor</option>
    <option value="2">Very Poor</option>
        </select></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><label>
      <input type="submit" name="button" id="button" class="mybutton" value="Submit" />
      </label></td>
  </tr>
</table>
</form></div>
<?php
if(isset($_POST['button'])){

	function insert($subjectyacho,$mark){
		 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
		if($mark=10)
		{
			$effort="Very Good";}
				if($mark=8)
		{
			$effort="Good";}	
			if($mark=6)
		{
			$effort="Average";}
				if($mark=4)
		{
			$effort="Poor";}
				if($mark=2)
		{
			$effort="Very Poor";}

$a=mysql_query("INSERT INTO results (reg,subject_id,subject,mark,effort,open,session,term,level,class)
VALUES
('$_REQUEST[reg]','$subjectyacho','habits','$mark','$effort','no','$_SESSION[year]','$_SESSION[term]','$grd','$class')") or die (mysql_error());

return $a;
	}
	insert("Follows Directions",$_POST['directions']);
	insert("Strives to Improve",$_POST['improve']);
	insert("Works Independently",$_POST['independent']);
	insert("Makes good use of Time",$_POST['time']);
	insert("Ability to concentrate",$_POST['concentrate']);
		insert("Homework",$_POST['homework']);

?>

  <?php
  // header("location: index.php?page=tab.php&reg=$_GET[reg]&name=$_GET[zita]&surname=$_GET[surame]&level=$_GET[level]#$_REQUEST[name]"); 
   }}
		?>