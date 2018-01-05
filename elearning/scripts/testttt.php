<?php
include ('opendb.php');
  $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' limit 1 ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];
		//echo $grd;
		}

// Fetch Record from Database

$output = "";
// Enter Your Table Name 
$sql = mysql_query("SELECT * FROM student_class,student where student_class.level='$grd' and student_class.student=student.reg and class='$class' order by surname asc");
$columns_total = mysql_num_fields($sql);

// Get The Field Name

//for ($i = 0; $i < $columns_total; $i++) {
//$heading = mysql_field_name($sql, $i);}
$output .= '"Name",';
$output .= '"Surname",';
$output .= '"Student#",';
$output .= '"",';
$output .= '"Mental_Maths",';
$output .= '"Problems_Maths",';
$output .= '"Mechanical_Maths",';
$output .= '"Test1_Maths",';
$output .= '"Test2_Maths",';


$output .= '"Spelling_English",';
$output .= '"Dictation_English",';
$output .= '"Comprehension_English",';
$output .= '"Language_English",';
$output .= '"Test1_English",';
$output .= '"Test2_English"';
$output .= '"Written_English",';
$output .= '"Reading_English",';
$output .= '"Hand_Writting_English",';

$output .= '"Scripture_Content",';
$output .= '"Science_Content",';
$output .= '"Social_Studies",';

$output .= '"SHONA",';

$output .= '"ART/CRAFT",';

$output .= '"COMPUTERS",';

$output .= '"Extra_Mural_Actvites",';
$output .= '"",';
$output .="\n";

// Get Records from the table

while ($row = mysql_fetch_array($sql)) {
for ($i = 0; $i < $columns_total; $i++) {
$output .='"'.$row["name"].'",';
$output .='"'.$row["surname"].'",';
$output .='"'.$row["reg"].'",';

}
$output .="\n";
}

// Download the file

$filename = "Mark_Schedule.csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo $output;
exit;

?>