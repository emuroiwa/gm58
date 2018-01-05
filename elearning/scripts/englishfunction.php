<?php
 function classavgg($x)
{
	 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
 $aanum = mysql_query("SELECT * FROM results where subject_id='english' and subject='$x' and session='$_SESSION[year]' and term='$_SESSION[term]' and class='$class' and level='$grd'  ")or die(mysql_query());
  $rowsaa = mysql_num_rows($aanum);
  
   $aa = mysql_query("SELECT Sum(results.mark) as n FROM results where subject_id='english' and subject='$x' and session='$_SESSION[year]' and term='$_SESSION[term]' and class='$class' and level='$grd'  ")or die(mysql_query());
 while($aarw = mysql_fetch_array($aa, MYSQL_ASSOC)){
  $spellingavg=$aarw['n'];}
  $spelling_classavg=$spellingavg/$rowsaa;
  $spelling_classavg_rounded=round($spelling_classavg, 2);
return $spelling_classavg_rounded;
}
function streamavgg($y)
{
	 $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
 $aanum = mysql_query("SELECT * FROM results where subject_id='english' and subject='$y' and session='$_SESSION[year]' and term='$_SESSION[term]'  and level='$grd'  ")or die(mysql_query());
  $rowsaa = mysql_num_rows($aanum);
  
   $aa = mysql_query("SELECT Sum(results.mark) as n FROM results where subject_id='english' and subject='$y' and session='$_SESSION[year]' and term='$_SESSION[term]'  and level='$grd'  ")or die(mysql_query());
 while($aarw = mysql_fetch_array($aa, MYSQL_ASSOC)){
  $stravg=$aarw['n'];}
  $all_stravg=$stravg/$rowsaa;
  $all_stravg_rounded=round($all_stravg, 2);
return  $all_stravg_rounded;
}
  function getmarkk($subjectyacho){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='english' and subject='$subjectyacho' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$_GET[reg]' ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
 while($rw1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
  $spelling=$rw1['mark'];} 
  return $spelling;  
  }
  function getmarkrowss($subjectyacho){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='english' and subject='$subjectyacho' and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$_GET[reg]' ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
  return $rows;  
  }
      function getmarkroww(){
	 $r1 = mysql_query("SELECT * FROM results where reg='$_GET[reg]' and subject_id='english'  and session='$_SESSION[year]' and term='$_SESSION[term]' and reg='$_GET[reg]' ")or die(mysql_query());
   $rows = mysql_num_rows($r1);
  return $rows;  
  }
?>