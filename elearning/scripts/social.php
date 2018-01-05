<?php
 
	 $r12 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='social'  and session='$_SESSION[year]' and term='$_SESSION[term]'  ")or die(mysql_query());
   $rows = mysql_num_rows($r12);
  
  while($socialmark = mysql_fetch_array($r12, MYSQL_ASSOC)){
  $art=$socialmark['mark'];
  } 
 // echo $rows;
	
	
  $directions=get1("Co-operates with Others","social");
   $improve=get1("Self Confidence","social");
    $independent=get1("Attitude to School","social");
	 $time=get1("School Behaviour","social");
	  $concentrate=get1("Leadership/Initiative","social"); 
	   $homework=get1("Care of Property","social"); 
  if($rows>0){
	//echo"<center><h4>Social Attitues</h4><br>
//<table border='1'  align='center'><tr bgcolor='#FFFFFF'><td><strong>Subjet</strong></td><td><strong>Effort Captured</strong></td><td><strong>Click To Edit</strong></td></tr>";
	
echo pano("Co-operates with Others",$directions,"social");
echo 	pano("Self Confidence",$improve,"social");
echo	pano("Attitude to School",$independent,"social");
echo	pano("School Behaviour",$time,"social");
echo	pano("Leadership/Initiative",$concentrate,"social");
echo		pano("Care of Property",$homework,"social");
	
	echo "</table>";


	
  }

?>
