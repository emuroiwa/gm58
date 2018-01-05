<?php function extra($subject,$year,$term){
  
  $mark= mysql_query("SELECT * FROM results ,student ,student_class WHERE results.reg = student.reg AND results.term ='$term' AND results.session ='$year' AND results.reg = '$_SESSION[reg]'  AND results.`open` = 'yes' AND student.reg = student_class.student  and subject='$subject'  ")or die(mysql_query());
 
	
		 
	 return $mark;

} 



while($row1 = mysql_fetch_array(extra("habits",$_SESSION['year'],$_SESSION['term']), MYSQL_ASSOC))
	  	  {$mark =$row1['effort'];
		  $sub =$row1['subject_id'];
		  echo"<table><tr><td></td></tr>";
		  }
?>