<?php function ageall($dob1) {
    list($m,$d,$y) = explode('/', $dob1);   
    if (($m = (date('m') - $m)) < 0) {
        $y++;
    } elseif ($m == 0 && date('d') - $d < 0) {
        $y++;
    }   
    return date('Y') - $y;
  }
$getname = mysql_query("SELECT * FROM student,student_class where level='$level' and class='$class' and student=reg")or die(mysql_query());
$students=mysql_num_rows($getname);
$dob_all=0; 
	while($rowname = mysql_fetch_array($getname, MYSQL_ASSOC))
	  	  {
		  $dob_all+=ageall($rowname['dob']);
		  $dob_all1=floor($dob_all/$students);
		 }
		 // overall position
		mysql_query("SET @row=0");
$pos=mysql_query("SELECT student,pos,average FROM (SELECT @row := @row+1 AS pos,student,average FROM average  where
 session='$_SESSION[year]' and `term`='$_SESSION[term]'  and subject_id = 'OVERALL' and grade = '$level' and class = '$class' ORDER BY average DESC) as n WHERE student='$_GET[reg]'");
  while($rowpos = mysql_fetch_array($pos, MYSQL_ASSOC)){
  $position=$rowpos['pos'];
  } if($averagee==100){$position=1;}

 ?>