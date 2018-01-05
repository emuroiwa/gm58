<!doctype html>
<html>
<head>
<meta charset="utf-8"><?php 
//error_reporting(0);
if(isset($_GET['name'])){
		  $name=$_GET['name']." ". $_GET['surname']; 
		  $title="$name  ($_GET[reg] )";
		  }?>
<title><?php echo "$title REPORT CARD"; ?></title> <style type='text/css'>
BODY {
    font-family:Arial, Helvetica, sans-serif;
	font-style:normal;

    font-size: 15.2px;
	font-variant:normal;
    background: #FFFFFF;
	
	  
}table {background:transparent;background-color:transparent; border-collapse: collapse;
} 
section { padding:0 !important; margin:0 !important;  width:27.5cm;height:35cm !important; overflow:hidden !important; }
</style>
</head>

<body onload="print()">
<?php
include 'function.php';
include 'opendb.php';
//get the class the kid is in
$getclass = mysql_query("SELECT * FROM student_class  WHERE student='$_GET[reg]' ")or die(mysql_query()); 
	while($rowclass = mysql_fetch_array($getclass, MYSQL_ASSOC))
	  	  {$class=$rowclass['class'];$level=$rowclass['level'];}
		  //get the number of kids in the class
		  	$getkids = mysql_query("SELECT * FROM student_class  WHERE class='$class' and level='$level' ")or die(mysql_query()); //get kidas name
$getname = mysql_query("SELECT * FROM student  WHERE student.reg='$_GET[reg]' ")or die(mysql_query()); 
	while($rowname = mysql_fetch_array($getname, MYSQL_ASSOC))
	  	  {$name=$rowname['name'];
		  $surname=$rowname['surname'];
		  $dob=$rowname['dob'];}
		  //get kids age
		  function age($dob) {
    list($m,$d,$y) = explode('/', $dob);   
    if (($m = (date('m') - $m)) < 0) {
        $y++;
    } elseif ($m == 0 && date('d') - $d < 0) {
        $y++;
    }   
    return date('Y') - $y;
  }	  
  
$full=$name." ".$surname;
$grd=$level." ".$class;
//page to work avg age and postion
 include 'age.php';
?>
<center><section><br><br>
<br>
<br><br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>


<!--<img src="../../student/images/object750153973.png" height="130">
-->
<table width="100%" border="0" align="center" style="border-image-slice:fill">
      <tr>
        
        <td width="20%" ><strong><font size="+1">PUPIL'S</font> </strong></td>        
        <td width="26%" ><strong>Name</strong>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $full; ?></td>
        <td width="23%">&nbsp;</td> <td width="31%"><strong>Term </strong><?php echo $_SESSION['term']." <strong>Year</strong> ".$_SESSION['year']; ?></td>
        
      </tr> <tr>
                <td><strong><font size="+1">PROGRESS</font></strong></td>
        <td><strong>Grade </strong><?php echo $grd; ?></td> 
        <td><strong>Pupils age <?php echo age($dob); ?>yrs</strong></td> 
        <td><strong>Average Age Of Class <?php echo $dob_all1; ?>yrs</strong></td> 
        
      </tr> <tr>
                <td><strong><font size="+1">REPORT</font></strong></td>
        <td><strong>Student average <?php echo "$total_avg%"; ?></strong></td> <td><strong>Class average <?php echo "$total_class%"; ?></strong></td> <td><strong>Class Position <?php echo "$position out of "."".mysql_num_rows($getkids); ?></strong></td> 
        
      </tr>
</table><hr>
<p align="left">Symbols:  A=Excellent  B=Good  C=Satisfactory  D=Poor  E=Weak/Unsatisfactory<br>Note:-Attainment is an assessment of child's attainment in relation to the whole class: Effort is an assessment as an individual.</p>
<table width="100%" border="0">
     <tr>
       <td width="35%"><table width="377" border="1">
         <tr>
           <td width="42%">SUBJECTS</td>
                <td width="19%">Class Average</td>
           <td width="20%">Attainment</td>
           <td width="19%">Effort</td>
      
         </tr>
       </table></td>
       <td  width="77%"><table width="100%" border="1">
        <tr height="40">
           <td align="center">REMARKS</td>
         </tr>
       </table></td>
  </tr>


<table width="100%" border="0">
  <tr>
    <td width="35%">
<table width="377" border="1">
 <tr>
        <td width="28%" ><strong>Maths</strong></td>
           <td width="13%" ><?php echo "<strong>$mathsavg</strong>"; ?></td>
         <td width="13%" ><?php echo "<strong>$maths_averagee</strong>"; ?></td>
      
        <td width="13%" >--</td>
       
      </tr>
      <tr>
        <td width="99" >Mechnical</td>
         <td width="73" ><?php echo $mec; ?></td>
        <td width="52" ><?php echo $mecmark; ?></td>
        <td width="49" ><?php echo $meceff; ?></td>
       
      </tr>
      <tr>
        <td width="99" >Mental</td>
                <td width="73" ><?php echo $men; ?></td>
        <td width="52" ><?php echo $menmark; ?></td>
        <td width="49" ><?php echo $meneff; ?></td>
      </tr>
      <tr>
        <td width="99" >Problems</td>  
             <td width="73" ><?php echo $prob; ?></td>
        <td width="52" ><?php echo $probmark; ?></td>
        <td width="49" ><?php echo $probeff; ?></td>
      </tr>
          
    </table></td>
    <td width="77%"><table width="100%"  border="1" bgcolor="#FFFFFF">
      <tr>
        <td width="504" height="84"><?php echo $maths_remarks; ?></td>
      </tr>
    </table> </td>
  </tr>
  <tr>
    <td><table width="377" border="1">
    <tr>
        <td width="28%" ><strong>English</strong></td>
           <td width="13%" ><?php echo "<strong>$englishavg</strong>"; ?></td>
                <td width="13%" ><?php echo "<strong>$english_averagee</strong>"; ?></td>
             
        <td width="13%" >--</td>
      </tr>
      <tr>
        <td width="99" >Spelling</td>
                <td width="73" ><?php echo $sp; ?></td> 
                       <td width="52" ><?php echo $spmark; ?></td>
        <td width="50" ><?php echo $speff; ?></td>
      </tr>
      <tr>
        <td width="99" >Language</td>
                <td width="73" ><?php echo $l; ?></td>
                        <td width="52" ><?php echo $lmark; ?></td>
        <td width="50" ><?php echo $leff; ?></td>
      </tr>
      <tr>
        <td width="99" >Comprehension </td>
                <td width="73" ><?php echo $c; ?></td>
                        <td width="52" ><?php echo $cmark; ?></td>
        <td width="50" ><?php echo $ceff; ?></td>
      </tr>
      <tr>
        <td width="99" >Dictation </td>
                <td width="73" ><?php echo $d; ?></td>
                        <td width="52" ><?php echo $dmark; ?></td>
        <td width="50" ><?php echo $deff; ?></td>
      </tr>
      <tr>
        <td width="99" >Hand Writing </td>
        <td width="50" ><?php echo '--'; ?></td>
                <td width="52" ><?php echo $hmark; ?></td>
        <td width="73" ><?php echo $hmark; ?></td>
      </tr>
      <tr>
        <td width="99" >Reading</td>
        <td width="50" ><?php echo '--'; ?></td>
                <td width="52" ><?php echo $rmark; ?></td>
        <td width="73" ><?php echo $rmark; ?></td>
      </tr>
      <tr>
        <td width="99" >Written English </td>
        <td width="50" ><?php echo '--'; ?></td>
                <td width="52" ><?php echo $wmark; ?></td>
       <td width="73" ><?php echo $wmark; ?></td>
      </tr>
    
      
    </table></td>
    <td><table width="100%" border="1" bgcolor="#FFFFFF">
      <tr>
        <td width="328" height="175" ><?php echo $english_remarks; ?></td>
      </tr>
    </table><tr>
    <td><table width="377" border="1">
      <tr height="40">
        <td width="28%" >  <strong>Shona</strong>        <?php echo shona(); ?></td>
        <td width="13%" ><strong><?php echo $shona_avg; ?></strong></td>
        <td width="13%" ><strong><?php echo $shona_mark; ?></strong></td>
        <td width="13%" ><strong><?php echo $shona_eff; ?></strong></td>
        
      </tr>
    </table></td>
    <td width="71%"><table width="100%" border="1" bgcolor="#FFFFFF">
      <tr height="39">
        <td width="71%" ><?php echo $shona_remarks; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="377" border="1"  height="74">
     
      <tr>
        <td width="28%" >Scripture</td>
         <td width="13%" >--</td>
        <td width="13%" ><?php echo $scri_mark; ?></td>
         <td width="13%" ><?php echo $scri_mark; ?></td>
       
      </tr>
      <tr>
        <td width="99" >Science</td>
         <td width="50" >--</td>
        <td width="53" ><?php echo $sci_mark; ?></td>
         <td width="50" ><?php echo $sci_mark; ?></td>
       
      </tr>
      <tr>
        <td width="99" >Social_Studies </td>
         <td width="50" >--</td>
        <td width="53" ><?php echo $ss_mark; ?></td>
         <td width="50" ><?php echo $scri_mark; ?></td>
           </tr>
    </table></td>
    <td><table width="100%"  border="1" bgcolor="#FFFFFF">
      <tr>
        <td width="304" height="70" ><?php echo $content_remarks; ?>
       </td>
      </tr>
    </table></td>
  </tr>
</table></table>
<table width="100%" border="0">
  <tr>
    <td><table width="377" border="1">
      <tr  height="43">
        <td width="28%"  ><strong>Computers</strong></td>
        <td width="13%"  >--</td>
        <td width="13%"  ><?php echo $compmark; ?></td>
        <td width="13%"  ><?php echo $compmark; ?></td>
        
      </tr>
    </table><table width="377" border="1">
      <tr  height="43">
        <td width="28%"  ><strong>Art/Craft</strong></td>
             <td width="13%"  >--</td>
        <td width="13%"  ><?php echo $art_mark; ?></td>
     
        <td width="13%"  ><?php echo $art_mark; ?></td>
        </tr>
    </table><table width="377" border="1">
      <tr  height="43">
        <td width="28%"   height="37.5"><strong>Extra_Mural
          _Actvites</strong></td>
        <td width="13%"  >--</td>
        <td width="13%"  >--</td>
        <td width="13%"  >--</td>
      </tr>
    </table></td>
    <td width="71%"><table width="100%" border="1">
      <tr>
        <td width="202"  height="40" ><?php echo $comp_remarks; ?></td>
      </tr>
    </table><table width="100%" border="1">
      <tr>
        <td width="202"   height="40" ><?php echo $art_remarks; ?></td>
      </tr>
    </table><table width="100%" border="1">
      <tr>
        <td width="202"   height="40" ><?php echo $extra_remarks; ?></td>
      </tr>
    </table></td>
  </tr>
</table><table width="100%" border="1">
 <tr>
		 <td width="28.99%"><strong>WORK AND SOCIAL HABITS</strong></td>
        <td width="3%"><strong>V.Good</strong></td> 
         <td width="3%"><strong>Good</strong></td> 
          <td width="3%"><strong>Average</strong></td>
            <td width="3%"><strong>Poor</strong></td>
              <td width="3%"><strong>V.Poor</strong></td>
        <td width="28.99%"><strong>SOCIAL ATTITUDES</strong></td>
<td width="3%"><strong>V.Good</strong></td> 
         <td width="3%"><strong>Good</strong></td> 
          <td width="3%"><strong>Average</strong></td>
            <td width="3%"><strong>Poor</strong></td>
              <td width="3%"><strong>V.Poor</strong></td>  </tr>
               <tr>
        <td>Follows Directions</td>
        <td><?php echo x(getsocial("Follows Directions","habits"),'V.Good'); ?></td>
        <td><?php echo x(getsocial("Follows Directions","habits"),'Good'); ?></td>
        <td><?php echo x(getsocial("Follows Directions","habits"),'Average'); ?></td>
        <td><?php echo x(getsocial("Follows Directions","habits"),'Poor'); ?></td>
        <td><?php echo x(getsocial("Follows Directions","habits"),'V.Poor'); ?></td>
        <td>Co-operates with Others</td>
        <td><?php echo x(getsocial("Co-operates with Others","social"),'V.Good'); ?></td>
        <td><?php echo x(getsocial("Co-operates with Others","social"),'Good'); ?></td>
        <td><?php echo x(getsocial("Co-operates with Others","social"),'Average'); ?></td>
        <td><?php echo x(getsocial("Co-operates with Others","social"),'Poor'); ?></td>
        <td><?php echo x(getsocial("Co-operates with Others","social"),'V.Poor'); ?></td>
      </tr> 
      <tr> 
        <td width="150"  >Works Independently</td>
        <td><?php echo x(getsocial("Works Independently","habits"),'V.Good'); ?></td>
        <td><?php echo x(getsocial("Works Independently","habits"),'Good'); ?></td>
        <td><?php echo x(getsocial("Works Independently","habits"),'Average'); ?></td>
        <td><?php echo x(getsocial("Works Independently","habits"),'Poor'); ?></td>
        <td><?php echo x(getsocial("Works Independently","habits"),'V.Poor'); ?></td>
        <td width="146" >Self Confidence</td> 
        <td><?php echo x(getsocial("Self Confidence","social"),'V.Good'); ?></td>
        <td><?php echo x(getsocial("Self Confidence","social"),'Good'); ?></td>
        <td><?php echo x(getsocial("Self Confidence","social"),'Average'); ?></td>
        <td><?php echo x(getsocial("Self Confidence","social"),'Poor'); ?></td>
        <td><?php echo x(getsocial("Self Confidence","social"),'V.Poor'); ?></td>
      </tr>
      <tr>
        <td  >Strives to Improve</td>
        <td><?php echo x(getsocial("Strives to Improve","habits"),'V.Good'); ?></td>
        <td><?php echo x(getsocial("Strives to Improve","habits"),'Good'); ?></td>
        <td><?php echo x(getsocial("Strives to Improve","habits"),'Average'); ?></td>
        <td><?php echo x(getsocial("Strives to Improve","habits"),'Poor'); ?></td>
        <td><?php echo x(getsocial("Strives to Improve","habits"),'V.Poor'); ?></td>
        <td>Attitude to School</td> 
          <td><?php echo x(getsocial("Attitude to School","social"),'V.Good'); ?></td>
        <td><?php echo x(getsocial("Attitude to School","social"),'Good'); ?></td>
        <td><?php echo x(getsocial("Attitude to School","social"),'Average'); ?></td>
        <td><?php echo x(getsocial("Attitude to School","social"),'Poor'); ?></td>
        <td><?php echo x(getsocial("Attitude to School","social"),'V.Poor'); ?></td>
      </tr>
      <tr>
        <td  >Makes good use of Time</td>
        <td><?php echo x(getsocial("Makes good use of Time","habits"),'V.Good'); ?></td>
        <td><?php echo x(getsocial("Makes good use of Time","habits"),'Good'); ?></td>
        <td><?php echo x(getsocial("Makes good use of Time","habits"),'Average'); ?></td>
        <td><?php echo x(getsocial("Makes good use of Time","habits"),'Poor'); ?></td>
        <td><?php echo x(getsocial("Makes good use of Time","habits"),'V.Poor'); ?></td>
        <td>School Behaviour</td> 
        <td><?php echo x(getsocial("School Behaviour","social"),'V.Good'); ?></td>
        <td><?php echo x(getsocial("School Behaviour","social"),'Good'); ?></td>
        <td><?php echo x(getsocial("School Behaviour","social"),'Average'); ?></td>
        <td><?php echo x(getsocial("School Behaviour","social"),'Poor'); ?></td>
        <td><?php echo x(getsocial("School Behaviour","social"),'V.Poor'); ?></td>
      </tr>
      <tr>
        <td  >Ability to concentrate</td>
        <td><?php echo x(getsocial("Ability to concentrate","habits"),'V.Good'); ?></td>
        <td><?php echo x(getsocial("Ability to concentrate","habits"),'Good'); ?></td>
        <td><?php echo x(getsocial("Ability to concentrate","habits"),'Average'); ?></td>
        <td><?php echo x(getsocial("Ability to concentrate","habits"),'Poor'); ?></td>
        <td><?php echo x(getsocial("Ability to concentrate","habits"),'V.Poor'); ?></td>
        <td>Leadership/Initiative</td>
        <td><?php echo x(getsocial("Leadership/Initiative","social"),'V.Good'); ?></td>
        <td><?php echo x(getsocial("Leadership/Initiative","social"),'Good'); ?></td>
        <td><?php echo x(getsocial("Leadership/Initiative","social"),'Average'); ?></td>
        <td><?php echo x(getsocial("Leadership/Initiative","social"),'Poor'); ?></td>
        <td><?php echo x(getsocial("Leadership/Initiative","social"),'V.Poor'); ?></td>
      </tr> <tr>
        <td width="150" >Homework</td>
          <td><?php echo x(getsocial("homework","habits"),'V.Good'); ?></td>
        <td><?php echo x(getsocial("homework","habits"),'Good'); ?></td>
        <td><?php echo x(getsocial("homework","habits"),'Average'); ?></td>
        <td><?php echo x(getsocial("homework","habits"),'Poor'); ?></td>
        <td><?php echo x(getsocial("homework","habits"),'V.Poor'); ?></td>
       <td width="146" >Care of Property</td> 
        <td><?php echo x(getsocial("Care of Property","social"),'V.Good'); ?></td>
        <td><?php echo x(getsocial("Care of Property","social"),'Good'); ?></td>
        <td><?php echo x(getsocial("Care of Property","social"),'Average'); ?></td>
        <td><?php echo x(getsocial("Care of Property","social"),'Poor'); ?></td>
        <td><?php echo x(getsocial("Care of Property","social"),'V.Poor'); ?></td>
        </tr>
    </table><table width="100%" border="1">
      <tr>
        
        <td  height="78"><strong>GENERAL REMARKS: </strong><?php echo remarks('overall',$_SESSION['year'],$_SESSION['term']);	  ; ?></td> 
        
      </tr> <tr height="37.5">
        
        <td><strong>HEAD REMARKS:</strong>&nbsp;<?php echo remarks('head',$_SESSION['year'],$_SESSION['term']);	  ; ?></td> 
        
      </tr>
    </table>
    <br>

Class teacher:.......................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    Head:....................................................................  
<br>.

</section>
</body>
</html>