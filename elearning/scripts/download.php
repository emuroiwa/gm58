<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<center><a href="csv.php"><font size="+1">>>>>> DOWNLOAD YOUR MARK SCHEDULE FOR Grade <?php echo " $grd $class class"; ?> <<<<<</font></a></center><hr><br>
<br>
<?php

 
function get_file_extension($file_name) {
    return end(explode('.',$file_name));
}
 
function errors($error){
    if (!empty($error))
    {
            $i = 0;
            while ($i < count($error)){
            $showError.= '<div class="msg-error">'.$error[$i].'</div>';
            $i ++;}
            return $showError;
    }// close if empty errors
} // close function	
 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
function insert($subject_id,$subject,$mark,$reg){
	global $grd;
	global $class;
		if ($mark>=80){
	$effort="A";
	}
	if ($mark>=70 AND $mark<=79 ){
	$effort="B";
	}
	if ($mark>=50 AND $mark<=69){
	$effort="C";
	}
	   if ($mark <=49 ){
	$effort = "D";
	}

$a=mysql_query("INSERT INTO results (reg,subject_id,subject,mark,effort,open,session,term,level,class)
VALUES
('$reg','$subject_id','$subject','$mark','$effort','no','$_SESSION[year]','$_SESSION[term]','$grd','$class')") or die (mysql_error());

return $a;
	}
	
 
if (isset($_POST['upfile'])){
// check feilds are not empty
 
if(get_file_extension($_FILES["uploaded"]["name"])!= 'csv')
{
$error[] = '<font color="#FF0000">Only Excel(.csv)  files accepted!</font>';
}
 
if (!$error){
 
$tot = 0;
$handle = fopen($_FILES["uploaded"]["tmp_name"], "r");
	
		 $check=mysql_query("SELECT * FROM results WHERE level='$grd' and class='$class' and term='$_SESSION[term]' and session='$_SESSION[year]'  and open='no' ") or die(mysql_error());
		 
			
								//VALIDATE IF ITS THE CORRECT EXCEL SHEET
				while ($line = fgetcsv($handle)){
  // count($line) is the number of columns
  $numcols = count($line);
  // Bail out of the loop if columns are incorrect
//echo $numcols; exit;
  if ($numcols != 24) {?>
  <script language="javascript">
 alert("Wrong excel document please makesure you filled out the correct number of columns");
 location = 'index.php?page=tab_upload.php'
  </script>
  <?php
 exit;  }else{	}
 if(mysql_num_rows($check)>0){
	 
								mysql_query("delete FROM results WHERE level='$grd' and class='$class' and term='$_SESSION[term]' and session='$_SESSION[year]' and open='no'") or die(mysql_error());}
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    for ($c=0; $c < 1; $c++) {
 
            //removing the headers
				
             
	

				
				       insert("Maths","Mental",mysql_real_escape_string($data[4]),mysql_real_escape_string($data[2]));
       insert("Maths","Problems",mysql_real_escape_string($data[5]),mysql_real_escape_string($data[2]));
	   insert("Maths","Mechanical",mysql_real_escape_string($data[6]),mysql_real_escape_string($data[2]));
	   insert("Maths","Test1",mysql_real_escape_string($data[7]),mysql_real_escape_string($data[2]));
	   insert("Maths","Test2",mysql_real_escape_string($data[8]),mysql_real_escape_string($data[2]));
	   insert("English","Spelling",mysql_real_escape_string($data[9]),mysql_real_escape_string($data[2]));
	   insert("English","Dictation",mysql_real_escape_string($data[10]),mysql_real_escape_string($data[2]));
	   insert("English","Comprehension",mysql_real_escape_string($data[11]),mysql_real_escape_string($data[2]));
	   insert("English","Language",mysql_real_escape_string($data[12]),mysql_real_escape_string($data[2]));
	   insert("English","Test1",mysql_real_escape_string($data[13]),mysql_real_escape_string($data[2]));
	   insert("English","Test2",mysql_real_escape_string($data[14]),mysql_real_escape_string($data[2]));
	   insert("English","Reading",mysql_real_escape_string($data[15]),mysql_real_escape_string($data[2]));
	   insert("English","Writting",mysql_real_escape_string($data[16]),mysql_real_escape_string($data[2]));
	   insert("English","Hand_writting",mysql_real_escape_string($data[17]),mysql_real_escape_string($data[2]));
	   insert("Content","Scripture",mysql_real_escape_string($data[18]),mysql_real_escape_string($data[2]));
	   insert("Content","Science",mysql_real_escape_string($data[19]),mysql_real_escape_string($data[2]));
	   insert("Content","Social_studies",mysql_real_escape_string($data[20]),mysql_real_escape_string($data[2]));
	   insert("other","Shona",mysql_real_escape_string($data[21]),mysql_real_escape_string($data[2]));
	   insert("other","Art_Craft",mysql_real_escape_string($data[22]),mysql_real_escape_string($data[2]));
	   insert("other","Computers",mysql_real_escape_string($data[23]),mysql_real_escape_string($data[2]));
				
			
                   
               
           
 
    $tot++;}
}
fclose($handle);
$content.= "<script language='javascript'>
 alert('EXCEL DOCUMENT UPLOADED... $tot STUDENTS CAPTURED');
 location = 'index.php?page=tab_upload.php#habits'
  </script>";
 
}}// end no error
}//close if isset upfile
//close else
$er = errors($error);
$content.= <<<EOF
<center><h4>Upload Marks Schedule</h4>
$er
<form enctype="multipart/form-data" action="" method="post">
<table border="1"><tr><td>
    Excel File:<input name="uploaded" type="file" maxlength="20" /></td><td><input type="submit" name="upfile" value="Upload File"></td></table>
</form></center>
EOF;
echo $content;

?>
</body>
</html>