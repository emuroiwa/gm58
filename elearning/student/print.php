<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<SCRIPT LANGUAGE="JavaScript">
if (window.print) {
document.write;
}
</script>
<body  onLoad="window.print()"><?php  
 include ('opendb.php'); include ('aut.php');

 $result1 = mysql_query("SELECT
*
FROM
results , student , student_class WHERE results.reg = student.reg AND results.reg = '$_SESSION[reg]'  AND results.`open` = 'yes' AND student.reg = student_class.student ")or die(mysql_query());
	$rowss = mysql_num_rows($result1);
	
		if($rowss==0)
 {
 	echo("<table align='center'  bgcolor='red'><tr><td>Your results are currently supressed sorry</td></tr></table>");  
			exit;}
 while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC))
	  	  
{
	

$name=$row1['name'];
$surname=$row1['surname'];
$level=$row1['level'];
$class=$row1['class'];

$session=$row1['session'];
$term=$row1['term'];
$reg=$row1['reg'];
$subject=$row1['subject_id'];
$grade=$row1['grade'];
$mark=$row1['mark'];


}

$r = mysql_query("SELECT Sum(results.mark) AS q, results.reg FROM results , student_class WHERE student_class.student = results.reg AND results.`level` = student_class.`level`  AND results.`open` = 'yes' AND results.term = '$_SESSION[term]'
ORDER BY q DESC LIMIT 10")or die(mysql_query());
 while($row = mysql_fetch_array($r, MYSQL_ASSOC))
	  	  
{
$regyake=$row['reg'];


}
$r1 = mysql_query("SELECT Sum(results.mark) AS q,results.reg FROM results ,student_class WHERE
student_class.student = results.reg AND results.`level` = student_class.`level` AND
results.`open` = 'yes' AND results.term = '$_SESSION[term]' ORDER BY q ASC  LIMIT 10")or die(mysql_query());
 while($ro = mysql_fetch_array($r1, MYSQL_ASSOC))
	  	  
{
$regyake1=$ro['reg'];


}

// mascience


if ($level== 2 AND $term==3 ){
$mascience = mysql_query("SELECT results.mark ,results.reg FROM results ,student_class  WHERE  results.`level` = 2 AND results.term=3 and results.subject_id = 'Intergrated Science' and results.reg = '$_SESSION[reg]' GROUP BY results.reg
")or die(mysql_query());
 while($ma = mysql_fetch_array($mascience , MYSQL_ASSOC))
	  	  
{
	$regnumber=$ma['reg'];
$mark=$ma['mark'];}
	
	$m = mysql_query("SELECT results.mark ,results.reg FROM results ,student_class WHERE results.`level` = 2 AND results.term=3 AND results.subject_id = 'Maths' AND results.reg = '$_SESSION[reg]' GROUP BY results.reg
")or die(mysql_query());
 while($ma1 = mysql_fetch_array($m , MYSQL_ASSOC))
	  	  
{	
$regnumber1=$ma1['reg'];
$mark1=$ma1['mark'];}
//echo "gn c $mark1";
$tot=$mark+$mark1;// totalS
	$check = mysql_query("SELECT * FROM dummy WHERE reg = '$_SESSION[reg]'")or die(mysql_query());
	$checking = mysql_num_rows($check);
	
if($checking==0)
 {
 	mysql_query("INSERT INTO dummy (reg,mark)
VALUES
('$regnumber','$tot')") or die (mysql_error());
			}
			

	$vapinda = mysql_query("SELECT * FROM dummy ORDER BY dummy.mark DESC LIMIT 3")or die(mysql_query());

while($b = mysql_fetch_array($vapinda , MYSQL_ASSOC)){
				$regvapinda=$b['reg'];
				//echo " $regvapinda";
				
  $fnames=explode(" ",$regvapinda);
		foreach($fnames as $fn)
		{
			
			//echo " $fnames";
 
if ($fn==$_SESSION['reg']){
	$decision="<table align='center'  bgcolor='#00CC00'><tr><td>automated form 3 sciences class choice coming soon!!!!!</td></tr></table>";
	}
	
	
	else{
			$decision="<table align='center'  bgcolor='red'><tr><td>automated form 3 sciences class choice coming soon!!!!!</td></tr></table>";

		} }} 
	  	  
	
$regnumber1=$ma1['reg'];
$mark1=$ma1['mark'];

}

//top 10
if ($regyake== $reg){
	$position="<font color='#009900'>automated TOP TEN of the stream coming soon!!!!!</font>";
	}
	elseif($regyake1== $reg){
	$position="<font color='red'>automated BOTTOM TEN of the stream  coming soon!!!!!</font> ";
	}
	else{
			$position="<font color='#009900'>Pass</font>";

		}
		
		

?>
<table width="373" border="0" align="center" style="border:1px solid #000000" bgcolor="#FFFFFF">
  <tr>
    <td width="152">Student number: </td><td width="209"><?php echo $reg; ?> </td></tr><tr>
    <td>Name: </td> <td><?php echo $name; ?> </td> 
    </tr>
  <tr>
    <td width="152">Surname: </td> 
    <td width="209"><?php echo $surname; ?></td>
  </tr>
  <tr>
    <td>Form: </td> <td><?php echo $level; ?></td> 
  </tr><tr>
    <td>Class: </td> <td><?php echo $class; ?></td> 
  </tr>
  <tr>
    <td>Term: </td>    
  <td><?php echo $term; ?></td> </tr>
  <tr>
    <td width="152">Year: </td> 
    <td width="209"><?php echo $session; ?></td>
  </tr><tr>
 <td width="152">POSITION</td> 
 <td width="209"><?php echo $position; ?></td>
  </tr>
</table>
<br>
<?php if ($level== 2 AND $term==3 ){ echo $decision; }?><br>

<table width="446" border="0" align="center" style="border:1px solid #000000" cellspacing="1" bgcolor="#FFFFFF">
  <tr bgcolor="#990000">
    <th width="242" >Subject</th>
    <th width="91" scope="col">Mark</th>
    <th width="91" scope="col">Grade</th>
  </tr><?php $result111 = mysql_query("SELECT * FROM results ,student ,student_class WHERE results.reg = student.reg AND results.term ='$_SESSION[term]' AND results.session ='$_SESSION[year]' AND results.reg = '$_SESSION[reg]'  AND results.`open` = 'yes' AND student.reg = student_class.student ")or die(mysql_query());
 while($row1 = mysql_fetch_array($result111, MYSQL_ASSOC))
	  	  
{$a ="<tr><td >{$row1['subject_id']}</td><td align='center'>{$row1['grade']}</td><td align='center'>{$row1['mark']}</td></tr>";
	echo $a; }?>
</table>
</body>
</html>