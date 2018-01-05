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
 <center><table width="80%" border="0">
  <tr>
    <td width="39%"><table width="341" border="1">
  <tr bgcolor="#FFFFFF">
    <th width="224" >Subject</th>
    
    <th width="101" >Effort</th>
  
  </tr> <tr>
    <td width="224" >Scripture</td>
    <td width="101" ><?php echo $spmark; ?></td>
 
  </tr> <tr>
    <td width="224" >Science</td>
    <td width="101" ><?php echo $lmark; ?></td>
   
  </tr><tr>
    <td width="224" >Social_Studies </td>
    <td width="101" ><?php echo $wmark; ?></td>
    
  </tr>
</table></td>
    <td width="61%"><table width="100%" border="1" bgcolor="#FFFFFF">
  <tr>
    <td><strong>Content Remarks</strong></td>
    </tr>
  <tr>
    <td width="540"><?php echo $remarks; ?></td>
    </tr>
</table></td>
  </tr>
</table>
<br>
</center>