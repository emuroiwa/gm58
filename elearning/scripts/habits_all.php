<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<center><a href="csv2.php"> <font size="+1">>>>DOWNLOAD SOCIAL HABITS & ATTITUDES MARK SCHEDULE <<<<<</font></a></center><hr><br>
<br><?php

 
function get_file_extension1($file_name1) {
    return end(explode('.',$file_name1));
}
 
function errors1($error1){
    if (!empty($error1))
    {
            $i1 = 0;
            while ($i1 < count($error1)){
            $showError1.= '<div class="msg-error">'.$error1[$i1].'</div>';
            $i1 ++;}
            return $showError1;
    }// close if empty errors
} // close function
function insert1($subject_id,$subject,$mark,$reg){
	global $all;
		 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
		if($mark==10 or $mark==9)
		{
			$effort="Very Good";}
				if($mark==8 or $mark==7)
		{
			$effort="Good";}	
			if($mark==6 or $mark==5)
		{
			$effort="Average";}
				if($mark==4 or $mark==3)
		{
			$effort="Poor";}
				if($mark<=2)
		{
			$effort="Very Poor";}

$a=mysql_query("INSERT INTO results (reg,subject_id,subject,mark,effort,open,session,term,class)
VALUES
('$reg','$subject_id','$subject','$mark','$effort','no','$_SESSION[year]','$_SESSION[term]','$all')") or die (mysql_error());

return $a;
	}
	
 
if (isset($_POST['upfile1'])){
// check feilds are not empty
 
if(get_file_extension1($_FILES["uploaded"]["name"])!= 'csv')
{
$error1[] = '<font color="#FF0000">Only Excel(.csv)  files accepted!</font>';
}
 
if (!$error1){
 
$tot1 = 0;
$handle1 = fopen($_FILES["uploaded"]["tmp_name"], "r");
	
 $check=mysql_query("SELECT * FROM results WHERE subject_id='social' or subject_id='habits' and term='$_SESSION[term]' and session='$_SESSION[year]' and class='$all'  and open='no'") or die(mysql_error());
		
							//VALIDATE IF ITS THE CORRECT EXCEL SHEET
				while ($line1 = fgetcsv($handle1)){
  // count($line) is the number of columns
  $numcols1 = count($line1);
  // Bail out of the loop if columns are incorrect
//echo $numcols; exit;
  if ($numcols1 != 16) {?>
  <script language="javascript">
 alert("Wrong excel document please makesure you filled out the correct number of columns");
 location = 'index.php?page=tab_upload.php'
  </script>
  <?php
 exit;  }else{	}
		if(mysql_num_rows($check)>0){
			//echo $all; exit;
								mysql_query("delete FROM results WHERE subject_id='social' and subject_id='habits' and term='$_SESSION[term]' and session='$_SESSION[year]' and class='$all'  and open='no'") or die(mysql_error());}
while (($data1 = fgetcsv($handle1, 1000, ",")) !== FALSE) {
    for ($c1=0; $c1 < 1; $c1++) {
 
            //removing the headers
               
       insert1("Habits","Follows Directions",mysql_real_escape_string($data1[4]),mysql_real_escape_string($data1[2]));
       insert1("Habits","Strives to Improve",mysql_real_escape_string($data1[5]),mysql_real_escape_string($data1[2]));
	   insert1("Habits","Works Independently",mysql_real_escape_string($data1[6]),mysql_real_escape_string($data1[2]));
	   insert1("Habits","Makes good use of Time",mysql_real_escape_string($data1[7]),mysql_real_escape_string($data1[2]));
	   insert1("Habits","Ability to concentrate",mysql_real_escape_string($data1[8]),mysql_real_escape_string($data1[2]));
	   insert1("Habits","Homework",mysql_real_escape_string($data1[9]),mysql_real_escape_string($data1[2]));
	insert1("Social","Co-operates with Others",mysql_real_escape_string($data1[10]),mysql_real_escape_string($data1[2]));
       insert1("Social","Self Confidence",mysql_real_escape_string($data1[11]),mysql_real_escape_string($data1[2]));
	   insert1("Social","Attitude to School",mysql_real_escape_string($data1[12]),mysql_real_escape_string($data1[2]));
	   insert1("Social","School Behaviour",mysql_real_escape_string($data1[13]),mysql_real_escape_string($data1[2]));
	   insert1("Social","Leadership/Initiative",mysql_real_escape_string($data1[14]),mysql_real_escape_string($data1[2]));
	   insert1("Social","Care of Property",mysql_real_escape_string($data1[15]),mysql_real_escape_string($data1[2]));
	   
 
                   
               
            
 
    $tot1++;}
}
fclose($handle1);
$content1.= "<script language='javascript'>
 alert('EXCEL DOCUMENT UPLOADED... $tot1 STUDENTS CAPTURED');
 location = 'index.php?page=students.php'
  </script>";

}// end no error
}//close if isset upfile
}
$er1 = errors1($error1);
$content1.= <<<EOF
<center><h4>Upload Social habits And Attitudes Marks Schedule</h4>
$er1
<form enctype="multipart/form-data" action="" method="post">
<table border="1"><tr><td>
    Excel File:<input name="uploaded" type="file" maxlength="20" /></td><td><input type="submit" name="upfile1" value="Upload File"></td></table>
</form></center>
EOF;
echo $content1;
?>
</body>
</html>