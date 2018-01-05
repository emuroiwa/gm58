<?php include 'resultfunction.php'?>
<?php
  //MATHS-----------------------------------------------------------------------------------------------------------------------
  //subject mark effort
  $mecmark=subjectresult('maths','mechanical',$_SESSION['year'],$_SESSION['term']);	  
$menmark=subjectresult('maths','mental',$_SESSION['year'],$_SESSION['term']);	  
$probmark=subjectresult('maths','problems',$_SESSION['year'],$_SESSION['term'])	;  
$t1mark=subjectresult('maths','test1',$_SESSION['year'],$_SESSION['term']);	  
$t2mark=subjectresult('maths','test2',$_SESSION['year'],$_SESSION['term']);	

  $meceff=subjecteffort('maths','mechanical',$_SESSION['year'],$_SESSION['term']);	  
$meneff=subjecteffort('maths','mental',$_SESSION['year'],$_SESSION['term']);	  
$probeff=subjecteffort('maths','problems',$_SESSION['year'],$_SESSION['term'])	;  
$t1eff=subjecteffort('maths','test1',$_SESSION['year'],$_SESSION['term']);	  
$t2eff=subjecteffort('maths','test2',$_SESSION['year'],$_SESSION['term']);	
  //echo $mecmark;
		//class avg  
$mec=ceil(classavg('maths','mechanical',$_SESSION['year'],$_SESSION['term']));	  
$men=ceil(classavg('maths','mental',$_SESSION['year'],$_SESSION['term']));	  
$prob=ceil(classavg('maths','problems',$_SESSION['year'],$_SESSION['term']))	;  
$t1=ceil(classavg('maths','test1',$_SESSION['year'],$_SESSION['term']));	  
$t2=ceil(classavg('maths','test2',$_SESSION['year'],$_SESSION['term']));
$mathsavg=round(($mec+$men+$prob+$t1+$t2)/5, 0);
//s avg  
$smec=streamavg('maths','mechanical',$_SESSION['year'],$_SESSION['term']);	  
$smen=streamavg('maths','mental',$_SESSION['year'],$_SESSION['term']);	  
$sprob=streamavg('maths','problems',$_SESSION['year'],$_SESSION['term'])	;  
$st1=streamavg('maths','test1',$_SESSION['year'],$_SESSION['term']);	  
$st2=streamavg('maths','test2',$_SESSION['year'],$_SESSION['term']);
$mathsavg1=round(($smec+$smen+$sprob+$st1+$st2)/5, 0);

//remark  
$remarks=remarks('maths',$_SESSION['year'],$_SESSION['term']);	  
//overall 
$overall=remarks('overall',$_SESSION['year'],$_SESSION['term']);
//head 
$head=remarks('head',$_SESSION['year'],$_SESSION['term']);
	 //student maths average 
$averagee=studentavg('maths',$_SESSION['year'],$_SESSION['term']);
	  
//EMNGLISH----------------------------------------------------------------------------------------------------------------------
  ?>	
  
  <center><?php echo "<strong>MATHS AVERAGE $averagee%</strong>"?><table width="84%" border="0">
  <tr>
    <td width="41%"><table width="377" border="1">
  <tr bgcolor="#FFFFFF">
    <th width="242" >Subject</th>
    <th width="126" >Mark</th>
    <th width="126" >Effort</th>
    <th width="126" >Class Average</th>
    </tr> <tr>
    <td width="242" >Mechnical</td>
    <td width="126" ><?php echo $mecmark.'%'; ?></td>
    <td width="126" ><?php echo $meceff; ?></td>
    <td width="126" ><?php echo $mec.'%'; ?></td>
    </tr> <tr>
    <td width="242" >Mental</td>
    <td width="126" ><?php echo $menmark.'%'; ?></td>
    <td width="126" ><?php echo $meneff; ?></td>
    <td width="126" ><?php echo $men.'%'; ?></td>
    </tr><tr>
    <td width="242" >Problems</td>
    <td width="126" ><?php echo $probmark.'%'; ?></td>
    <td width="126" ><?php echo $probeff; ?></td>
    <td width="126" ><?php echo $prob.'%'; ?></td>
    </tr><tr>
    <td width="242" ><strong>Averages</strong></td>
    <td width="126" ><?php echo "<strong>$averagee</strong>".'%'; ?></td>
    <td width="126" >--</td>
    <td width="126" ><?php echo "<strong>$mathsavg</strong>".'%'; ?></td>
    </tr>
</table>
</td>
    <td width="59%"><table width="100%" border="1" bgcolor="#FFFFFF">
  <tr>
    <td width="556"><strong>Maths Remarks</strong></td>
    </tr>
  <tr>
    <td><?php echo $remarks; ?></td>
    </tr>
</table></td>
  </tr>
</table>


</center>