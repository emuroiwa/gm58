<?php function insert($subjectyacho,$mark){
		 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
		if($mark=10)
		{
			$effort="Very Good";}
				if($mark=8)
		{
			$effort="Good";}	
			if($mark=6)
		{
			$effort="Average";}
				if($mark=4)
		{
			$effort="Poor";}
				if($mark=2)
		{
			$effort="Very Poor";}

$a=mysql_query("INSERT INTO results (reg,subject_id,subject,mark,effort,open,session,term,level,class)
VALUES
('$_REQUEST[reg]','$subjectyacho','habits','$mark','$effort','no','$_SESSION[year]','$_SESSION[term]','$grd','$class')") or die (mysql_error());
return $a;
	}
	insert("Follows Directions",fv);
	
?>