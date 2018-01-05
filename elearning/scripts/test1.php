<?php

	include 'opendb.php';
$sql="select * from news";
	$str = '{ "options": [';
	$rs = mysql_query("select * from news where id = '22'");
	$cnt = 0;
	while($row=mysql_fetch_array($rs,MYSQL_ASSOC)){ 
		
		$str.= '{"value": "'.$row['id'].'", "text": "'.$row['title'].'"}';
		$cnt++;
		if($cnt != count($rs))
			$str.= ',';
	}

	$str.= '] }';
	echo $str;

?>
	