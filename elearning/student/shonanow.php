<?php
  //other-----------------------------------------------------------------------------------------------------------------------
  //subject mark effort
  $spmark=subjectresult('other','shona',$_SESSION['year'],$_SESSION['term']);	  


  $speff=subjectask('other','shona',$_SESSION['year'],$_SESSION['term']);	  

  //echo $mecmark;
		//class avg  
$sp=subjectotal('other','shona',$_SESSION['year'],$_SESSION['term']);	  


//s avg  
$ssp=streamavg('other','shona',$_SESSION['year'],$_SESSION['term']);	  



//remark  
$remarks=remarks('shona',$_SESSION['year'],$_SESSION['term']);	  
//overall 
$overall=remarks('overall',$_SESSION['year'],$_SESSION['term']);
//head 
$head=remarks('head',$_SESSION['year'],$_SESSION['term']);
	 //student maths average 
$averagee=studentavg('shona',$_SESSION['year'],$_SESSION['term']);
	  
//EMNGLISH----------------------------------------------------------------------------------------------------------------------
  ?>
	  
<center> <?php echo "<strong>Marks for $_GET[date]</strong>"?><table width="377" border="1">
  <tr bgcolor="#FFFFFF">
     <th width="242" >Subject</th>
    <th width="126" >Mark</th>
    <th width="126" >Task</th>
    <th width="126" >Out Of</th>
  </tr> <tr>
    <td width="242" ><?php echo shona(); ?></td>
    <td width="126" ><?php echo $spmark; ?></td>
    <td width="126" ><?php echo $speff; ?></td>
    <td width="126" ><?php echo $sp; ?></td>
  </tr> 
</table>
<br>
</center>