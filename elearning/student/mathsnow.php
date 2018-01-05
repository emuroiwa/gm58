<?php include 'marksfunction.php'?>
<?php
  //MATHS-----------------------------------------------------------------------------------------------------------------------
  //subject mark effort
  $mecmark=subjectresult('maths','mechanical',$_SESSION['year'],$_SESSION['term']);	  
$menmark=subjectresult('maths','mental',$_SESSION['year'],$_SESSION['term']);	  
$probmark=subjectresult('maths','problems',$_SESSION['year'],$_SESSION['term'])	;  
$t1mark=subjectresult('maths','Classwork',$_SESSION['year'],$_SESSION['term']);	  
$t2mark=subjectresult('maths','Homework',$_SESSION['year'],$_SESSION['term']);	

  $meceff=subjectask('maths','mechanical',$_SESSION['year'],$_SESSION['term']);	  
$meneff=subjectask('maths','mental',$_SESSION['year'],$_SESSION['term']);	  
$probeff=subjectask('maths','problems',$_SESSION['year'],$_SESSION['term'])	;  
$t1eff=subjectask('maths','Classwork',$_SESSION['year'],$_SESSION['term']);	  
$t2eff=subjectask('maths','Homework',$_SESSION['year'],$_SESSION['term']);	
  //echo $mecmark;
		//class avg  
$mec=subjectotal('maths','mechanical',$_SESSION['year'],$_SESSION['term']);	  
$men=subjectotal('maths','mental',$_SESSION['year'],$_SESSION['term']);	  
$prob=subjectotal('maths','problems',$_SESSION['year'],$_SESSION['term'])	;  
$t1=subjectotal('maths','Classwork',$_SESSION['year'],$_SESSION['term']);	  
$t2=subjectotal('maths','Homework',$_SESSION['year'],$_SESSION['term']);
$mathsavg=round(($mec+$men+$prob+$t1+$t2)/5, 2);
//s avg  
$smec=streamavg('maths','mechanical',$_SESSION['year'],$_SESSION['term']);	  
$smen=streamavg('maths','mental',$_SESSION['year'],$_SESSION['term']);	  
$sprob=streamavg('maths','problems',$_SESSION['year'],$_SESSION['term'])	;  
$st1=streamavg('maths','test1',$_SESSION['year'],$_SESSION['term']);	  
$st2=streamavg('maths','test2',$_SESSION['year'],$_SESSION['term']);
$mathsavg1=round(($smec+$smen+$sprob+$st1+$st2)/5, 2);

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
  
  <center><?php echo "<strong>Marks for $_GET[date]</strong>"?><table width="377" border="1">
  <tr bgcolor="#FFFFFF">
    <th width="242" >Subject</th>
    <th width="126" >Mark</th>
    <th width="126" >Task</th>
    <th width="126" >Out Of</th>
   
  </tr> <tr>
    <td width="242" >Mechnical</td>
    <td width="126" ><?php echo $mecmark; ?></td>
    <td width="126" ><?php echo $meceff; ?></td>
    <td width="126" ><?php echo $mec; ?></td>
  </tr> <tr>
    <td width="242" >Mental</td>
    <td width="126" ><?php echo $menmark; ?></td>
    <td width="126" ><?php echo $meneff; ?></td>
    <td width="126" ><?php echo $men ; ?></td>
  </tr><tr>
    <td width="242" >Problems</td>
    <td width="126" ><?php echo $probmark ; ?></td>
    <td width="126" ><?php echo $probeff; ?></td>
    <td width="126" ><?php echo $prob ; ?></td>
  </tr><tr>
    <td width="242" >Test1</td>
    <td width="126" ><?php echo $t1mark ; ?></td>
    <td width="126" ><?php echo $t1eff; ?></td>
    <td width="126" ><?php echo $t1 ; ?></td>
  </tr><tr>
    <td width="242" >Test2</td>
    <td width="126" ><?php echo $t2mark ; ?></td>
    <td width="126" ><?php echo $t2eff; ?></td>
    <td width="126" ><?php echo $t2 ; ?></td>
  </tr>
</table>



</center>