<?php
include ('opendb.php');include ('aut.php'); 
$Today = date('y:m:d');
                        $new = date('l_F_d_Y', strtotime($Today));
                      
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


$output .= '"Name",';
$output .= '"Surname",';
$output .= '"Student#",';
$output .= '"",';
$output .= '"Mental_Maths",';
$output .= '"Problems_Maths",';
$output .= '"Mechanical_Maths",';
$output .= '"Classwork",';
$output .= '"Homework",';


$output .= '"Spelling_English",';
$output .= '"Dictation_English",';
$output .= '"Comprehension_English",';
$output .= '"C/W Language",';
$output .= '"H/W Language",';
$output .= '"H/W Spelling",';
$output .= '"Written_English",';
$output .= '"Reading_English",';
$output .= '"Hand_Writting_English",';

$output .= '"Scripture_Content",';
$output .= '"Science_Content",';
$output .= '"Social_Studies",';

$output .= '"SHONA",';

$output .= '"ART/CRAFT",';

$output .= '"COMPUTERS",';

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

$output.='"TASK ",';
$output.='"FOR ",';
$output.="MARKS";
$output .="\n";
$output.='"TOTAL ",';
$output.='"ATTAINABLE ",';
$output.="SCORE";
$output .="\n";
// Download the file
$title="MARKS_BOOK"."_".$new;
$filename = "$title.csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo $output;
exit;

?>