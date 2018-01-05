<?php
  //other-----------------------------------------------------------------------------------------------------------------------
  //subject mark effort
  $spmark=subjectresult('other','shona',$_SESSION['year'],$_SESSION['term']);	  


  $speff=subjecteffort('other','shona',$_SESSION['year'],$_SESSION['term']);	  

  //echo $mecmark;
		//class avg  
$sp=ceil(classavg('other','shona',$_SESSION['year'],$_SESSION['term']));	  


//s avg  
$ssp=streamavg('other','shona',$_SESSION['year'],$_SESSION['term']);	  



//remark  
$remarks=remarks('shona',$_SESSION['year'],$_SESSION['term']);	  
//overall 
$overall=remarks('overall',$_SESSION['year'],$_SESSION['term']);
//head 
$head=remarks('head',$_SESSION['year'],$_SESSION['term']);
	 //student maths average 
$averagee=ceil(studentavg('shona',$_SESSION['year'],$_SESSION['term']));
	  
//EMNGLISH----------------------------------------------------------------------------------------------------------------------
  ?>
	  
<center> <?php echo "<strong>SHONA AVERAGE $averagee%</strong>"?><table width="84%" border="0">
  <tr>
    <td width="41%"><table width="377" border="1">
  <tr bgcolor="#FFFFFF">
    <th width="242" >Subject</th>
    <th width="126" >Mark</th>
    <th width="126" >Effort</th>
    <th width="126" >Class Average</th>
    </tr> <tr>
    <td width="242" ><?php echo shona(); ?></td>
    <td width="126" ><?php echo $spmark.'%'; ?></td>
    <td width="126" ><?php echo $speff; ?></td>
    <td width="126" ><?php echo $sp.'%'; ?></td>
    </tr> 
</table></td>
    <td width="59%"><table width="100%" border="1" bgcolor="#FFFFFF">
  <tr>
    <td><strong>Shona Remarks</strong></td>
    </tr>
  <tr>
    <td width="540"><?php echo $remarks; ?></td>
    </tr>
</table></td>
  </tr>
</table>
<br>
</center>