<?php
  //other-----------------------------------------------------------------------------------------------------------------------
  //subject mark effort
  $spmark=subjectresult('other','Extra_Mural_Actvites',$_SESSION['year'],$_SESSION['term']);	  


  $speff=subjecteffort('other','Extra_Mural_Actvites',$_SESSION['year'],$_SESSION['term']);	  

  //echo $mecmark;
		//class avg  



//remark  
$remarks=remarks('Extra_Mural_Actvites',$_SESSION['year'],$_SESSION['term']);	  
//overall 
$overall=remarks('overall',$_SESSION['year'],$_SESSION['term']);
//head 
$head=remarks('head',$_SESSION['year'],$_SESSION['term']);
	 //student maths average 
//$averagee=studentavg('Extra_Mural_Actvites',$_SESSION['year'],$_SESSION['term']);
	  
//EMNGLISH----------------------------------------------------------------------------------------------------------------------
  ?>
<center><table width="293" border="1">
  <tr bgcolor="#FFFFFF">
    
    <th width="283" >Teacher Remark</th>
    
  </tr> <tr>
    
    <td height="55" ><?php echo $remarks; ?></td>
    
  </tr> 
</table><br>
</center>