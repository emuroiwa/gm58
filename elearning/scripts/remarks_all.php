<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<center><a href="csv3.php"> <h6>DOWNLOAD REMARKS WORKSHEET FOR Grade <?php echo " $grd $class class"; ?> </h6></a></center><hr><?php

 
function get_file_extension2($file_name2) {
    return end(explode('.',$file_name2));
}
 
function errors2($error2){
    if (!empty($error2))
    {
            $i2 = 0;
            while ($i2 < count($error2)){
            $showError2.= '<div class="msg-error">'.$error2[$i2].'</div>';
            $i2 ++;}
            return $showError2;
    }// close if empty errors
} // close function
function insert2($subject_id,$remark,$reg){
	$date = date('m/d/Y');

$a=mysql_query("INSERT INTO remarks (student,remark,session,term,date,subject_id,teacher)
VALUES
('$reg','$remark','$_SESSION[year]','$_SESSION[term]','$date','$subject_id','$_SESSION[username]')") or die (mysql_error());

return $a;
	}
	
 
if (isset($_POST['upfile2'])){
// check feilds are not empty
 
if(get_file_extension2($_FILES["uploaded"]["name"])!= 'csv')
{
$error2[] = 'Only CSV files accepted!';
}
 
if (!$error2){
 
$tot2 = 0;
$handle2 = fopen($_FILES["uploaded"]["tmp_name"], "r");

 $check=mysql_query("SELECT * FROM remarks WHERE teacher ='$_SESSION[username]' and term='$_SESSION[term]' and session='$_SESSION[year]'") or die(mysql_error());
			if(mysql_num_rows($check)>0){
				mysql_query("delete FROM remarks WHERE teacher ='$_SESSION[username]' and term='$_SESSION[term]' and session='$_SESSION[year]'") or die(mysql_error());}
				//VALIDATE IF ITS THE CORRECT EXCEL SHEET
				
while (($data2 = fgetcsv($handle2, 1000, ",")) !== FALSE) {
    for ($c2=0; $c2 < 1; $c2++) {
 
            //removing the headers

             if ($i == 0) { $i++; continue; }
	
       insert2("maths",mysql_real_escape_string($data2[4]),mysql_real_escape_string($data2[2]));
       insert2("english",mysql_real_escape_string($data2[5]),mysql_real_escape_string($data2[2]));
	   insert2("content",mysql_real_escape_string($data2[6]),mysql_real_escape_string($data2[2]));
	   insert2("shona",mysql_real_escape_string($data2[7]),mysql_real_escape_string($data2[2]));
	   insert2("Art_Craft",mysql_real_escape_string($data2[8]),mysql_real_escape_string($data2[2]));
	   insert2("Extra_Mural_Actvites",mysql_real_escape_string($data2[9]),mysql_real_escape_string($data2[2]));
	insert2("Computers",mysql_real_escape_string($data2[10]),mysql_real_escape_string($data2[2]));
       insert2("overall",mysql_real_escape_string($data2[11]),mysql_real_escape_string($data2[2]));
	   insert2("head",mysql_real_escape_string($data2[12]),mysql_real_escape_string($data2[2]));
	 
 
    $tot2++;}
}
fclose($handle2);
$content2.= "<div class='success' id='message'> Excel File Imported, $tot2 records added </div>";
 
}// end no error
}//close if isset upfile

$er2 = errors2($error2);
$content2.= <<<EOF
<center><h4>Upload Remarks </h4>
$er2
<form enctype="multipart/form-data" action="" method="post">
<table border="1"><tr><td>
    Excel File:<input name="uploaded" type="file" maxlength="20" /></td><td><input type="submit" name="upfile2" value="Upload File"></td></table>
</form></center>
EOF;
echo $content2;
?>
</body>
</html>