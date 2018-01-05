<?php
  //other-----------------------------------------------------------------------------------------------------------------------
  //subject mark effort
  $spmark=subjectresult('other','Art_Craft',$_SESSION['year'],$_SESSION['term']);	  


  $compmark=subjecteffort('other','computers',$_SESSION['year'],$_SESSION['term']);	  

  //echo $mecmark;
		//class avg  



//remark  
$remarks=remarks('Art_Craft',$_SESSION['year'],$_SESSION['term']);	
$remarkscomp=remarks('computers',$_SESSION['year'],$_SESSION['term']);	  
//overall 
$overall=remarks('overall',$_SESSION['year'],$_SESSION['term']);
//head 
$head=remarks('Extra_Mural_Actvites',$_SESSION['year'],$_SESSION['term']);
	 //student maths average 
//$averagee=studentavg('Extra_Mural_Actvites',$_SESSION['year'],$_SESSION['term']);
	  
//EMNGLISH----------------------------------------------------------------------------------------------------------------------
  ?>
<center><table width="431" border="1">
  <tr bgcolor="#FFFFFF">
    
    
    <th width="136" >Subject</th> <th width="39" >Effort</th>
    <th width="234" >Teacher Remark</th>
    
  </tr> <tr>
    
    <td  >Art/Craft</td>
    <td  ><?php echo $spmark; ?></td>
    <td ><?php echo $remarks; ?></td>
    
  </tr> <tr>
    
    <td  >Computers</td>
    <td  ><?php echo $compmark; ?></td>
    <td ><?php echo $remarkscomp; ?></td>
    
  </tr> <tr>
    
    <td  >Extra_Mural_Actvites</td>
    <td  >--</td>
    <td ><?php echo $head; ?></td>
    
  </tr> 
</table><br>
</center>