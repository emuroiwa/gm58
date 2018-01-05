<?php
  //other-----------------------------------------------------------------------------------------------------------------------
  //subject mark effort
  $spmark=subjectresult('other','Art_Craft',$_SESSION['year'],$_SESSION['term']);	  


  $compmark=subjectresult('other','computers',$_SESSION['year'],$_SESSION['term']);	  

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
<center><table width="377" border="1">
  <tr bgcolor="#FFFFFF">
    
    
    <th width="242" >Subject</th>
    <th width="126" >Mark</th>
    <th width="126" >Task</th>
    <th width="126" >Out Of</th>
  </tr> <tr>
    
    <td  >Art/Craft</td>
    <td  ><?php echo $spmark; ?></td>
    <td ><?php echo subjectask('other','Art_Craft',$_SESSION['year'],$_SESSION['term']);?></td>
    <td ><?php echo subjectotal('other','Art_Craft',$_SESSION['year'],$_SESSION['term']);?></td>
    
  </tr> <tr>
    
    <td  >Computers</td>
        <td  ><?php echo $compmark; ?></td>
    <td ><?php echo subjectask('other','computers',$_SESSION['year'],$_SESSION['term']);?></td>
    <td ><?php echo subjectotal('other','computers',$_SESSION['year'],$_SESSION['term']);?></td>
    
  </tr> 
</table><br>
</center>