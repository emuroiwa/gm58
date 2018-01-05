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
$mec=classavg('maths','mechanical',$_SESSION['year'],$_SESSION['term']);	  
$men=classavg('maths','mental',$_SESSION['year'],$_SESSION['term']);	  
$prob=classavg('maths','problems',$_SESSION['year'],$_SESSION['term'])	;  
$t1=classavg('maths','test1',$_SESSION['year'],$_SESSION['term']);	  
$t2=classavg('maths','test2',$_SESSION['year'],$_SESSION['term']);
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
  
  <?php echo "<strong>MATHS AVERAGE $averagee%</strong>"?><center><table width="377" border="1">
  <tr>
    <th width="242" >Subject</th>
    <th width="126" >Mark</th>
    <th width="126" >Effort</th>
    <th width="126" >Class Average</th>
    <th width="126" >Stream Average</th>
  </tr> <tr>
    <td width="242" >Mechnical</td>
    <td width="126" ><?php echo $mecmark.'%'; ?></td>
    <td width="126" ><?php echo $meceff; ?></td>
    <td width="126" ><?php echo $mec.'%'; ?></td>
    <td width="126" ><?php echo $smec.'%'; ?></td>
  </tr> <tr>
    <td width="242" >Mental</td>
    <td width="126" ><?php echo $menmark.'%'; ?></td>
    <td width="126" ><?php echo $meneff; ?></td>
    <td width="126" ><?php echo $men.'%'; ?></td>
    <td width="126" ><?php echo $smen.'%'; ?></td>
  </tr><tr>
    <td width="242" >Problems</td>
    <td width="126" ><?php echo $probmark.'%'; ?></td>
    <td width="126" ><?php echo $probeff; ?></td>
    <td width="126" ><?php echo $prob.'%'; ?></td>
    <td width="126" ><?php echo $sprob.'%'; ?></td>
  </tr><tr>
    <td width="242" >Test1</td>
    <td width="126" ><?php echo $t1mark.'%'; ?></td>
    <td width="126" ><?php echo $t1eff; ?></td>
    <td width="126" ><?php echo $t1.'%'; ?></td>
    <td width="126" ><?php echo $st1.'%'; ?></td>
  </tr><tr>
    <td width="242" >Test2</td>
    <td width="126" ><?php echo $t2mark.'%'; ?></td>
    <td width="126" ><?php echo $t2eff; ?></td>
    <td width="126" ><?php echo $t2.'%'; ?></td>
    <td width="126" ><?php echo $st2.'%'; ?></td>
  </tr>
</table></center><?php echo $remarks; ?><br>
<?php echo $overall; ?><br>
<?php echo $head; ?>