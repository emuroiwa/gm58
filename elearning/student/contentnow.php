<?php
  //english-----------------------------------------------------------------------------------------------------------------------
  //subject mark effort
  $spmark=subjectresult('content','Scripture',$_SESSION['year'],$_SESSION['term']);	  
$lmark=subjectresult('content','Science',$_SESSION['year'],$_SESSION['term']);	  
$wmark=subjectresult('content','Social_Studies',$_SESSION['year'],$_SESSION['term'])	;  

//remark  
$remarks=remarks('content',$_SESSION['year'],$_SESSION['term']);	  
//overall 
$overall=remarks('overall',$_SESSION['year'],$_SESSION['term']);
//head 
$head=remarks('head',$_SESSION['year'],$_SESSION['term']);
	 //student maths average 
	  
//EMNGLISH----------------------------------------------------------------------------------------------------------------------
  ?>	  
 <center><?php echo "<strong>Marks for $_GET[date]</strong>"?><table width="341" border="1">
  <tr bgcolor="#FFFFFF">
    <th width="242" >Subject</th>
    <th width="126" >Mark</th>
    <th width="126" >Task</th>
    <th width="126" >Out Of</th>
  </tr> <tr>
    <td width="224" >Scripture</td>
    <td width="101" ><?php echo $spmark; ?></td>
    <td width="101" ><?php echo subjectask('content','Scripture',$_SESSION['year'],$_SESSION['term']);	   ?></td>
    <td width="101" ><?php echo subjectotal('content','Scripture',$_SESSION['year'],$_SESSION['term']); ?></td>
 
  </tr> <tr>
    <td width="224" >Science</td>
    <td width="101" ><?php echo $lmark; ?></td>
    <td width="101" ><?php echo subjectask('content','Science',$_SESSION['year'],$_SESSION['term']);	   ?></td>
    <td width="101" ><?php echo subjectotal('content','Science',$_SESSION['year'],$_SESSION['term']); ?></td>
  </tr><tr>
    <td width="224" >Social_Studies </td>
    <td width="101" ><?php echo $wmark; ?></td>
    <td width="101" ><?php echo subjectask('content','Social_studies',$_SESSION['year'],$_SESSION['term']);	  ?></td>
    <td width="101" ><?php echo subjectotal('content','Social_studies',$_SESSION['year'],$_SESSION['term']); ?></td>
  </tr>
</table>
<br>
</center>