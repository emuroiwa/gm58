<?php
include ('opendb.php');
  $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' limit 1 ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];
		//echo $grd;
		}
$filename = 'Mark_Schedule';   
$result = mysql_query("SELECT * FROM student_class,student where student_class.level='$grd' and student_class.student=student.reg and class='$class' and status='ENROLLED' order by surname asc");
$file_ending = "xls";
//header info for browser
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$filename.csv");
header("Pragma: no-cache");
header("Expires: 0");

$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
/*for ($i = 0; $i < mysql_num_fields($result); $i++) {
echo mysql_field_name($result,$i) . "\t";
}*/
echo "Name" . "\t";
echo " " . "\t";
echo "Surname" . "\t";
echo "Surname" . "\t";
echo "Surname" . "\t";
echo "Surname" . "\t";
echo "Surname" . "\t";
echo "Surname" . "\t";
print("\n");
   while($row = mysql_fetch_array($result))
    {
        $schema_insert = "";
        
if(!isset($row['name']))
                $schema_insert .= "NULL".$sep;
            elseif ($row['name'] != "")
                $schema_insert .= 
				"$row[name]".$sep.
				" ".$sep.
				"$row[name]".$sep.
				"$row[name]".$sep.
				"$row[name]".$sep.
				"$row[name]".$sep.
				"$row[surname]".$sep;
            else
                $schema_insert .= "".$sep;

        $schema_insert = str_replace($sep."$", "", $schema_insert);
$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";

	

    }?>