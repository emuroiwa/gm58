<?php
include ('opendb.php');include ('aut.php');
  $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' limit 1 ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];
		//echo $grd;
		}

// Fetch Record from Database

$output = "";
// Enter Your Table Name 
$sql = mysql_query("SELECT * FROM student_class,student where student_class.level='$grd' and student_class.student=student.reg and class='$class' and status='ENROLLED' order by sex asc, surname asc");
$columns_total = mysql_num_fields($sql);

// Get The Field Name

//for ($i = 0; $i < $columns_total; $i++) {
//$heading = mysql_field_name($sql, $i);}
$output .= '"Name",';
$output .= '"Surname",';
$output .= '"Student#",';
$output .= '"",';
$output .= '"Follows Directions",';
$output .= '"Strives to Improve",';
$output .= '"Works Independently",';
$output .= '"Makes good use of Time",';
$output .= '"Ability to concentrate",';
$output .= '"Homework",';
$output .= '"Co-operates with Others",';
$output .= '"Self Confidence",';
$output .= '"Attitude to School",';
$output .= '"School Behaviour",';
$output .= '"Leadership/Initiative",';
$output .= '"Care of Property",';


$output .= '"",';
$output .="\n";

// Get Records from the table

while ($row = mysql_fetch_array($sql)) {
for ($i = 0; $i < $columns_total; $i++) {}
$output .='"'.$row["name"].'",';
$output .='"'.$row["surname"].'",';
$output .='"'.$row["reg"].'",';


$output .="\n";
}

// Download the file

$filename = "SOCIAL_HABITS_AND_ATTITUDES.csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo $output;
exit;

?>