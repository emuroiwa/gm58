<?php
  //english-----------------------------------------------------------------------------------------------------------------------
  //subject mark effort
  $spmark=subjectresult('english','spelling',$_SESSION['year'],$_SESSION['term']);	  
$lmark=subjectresult('english','language',$_SESSION['year'],$_SESSION['term']);	  
$wmark=subjectresult('english','writting',$_SESSION['year'],$_SESSION['term'])	;  
$cmark=subjectresult('english','comprehension',$_SESSION['year'],$_SESSION['term'])	;  
$dmark=subjectresult('english','dictation',$_SESSION['year'],$_SESSION['term'])	;  
$hmark=subjectresult('english','hand_writting',$_SESSION['year'],$_SESSION['term'])	;  
$rmark=subjectresult('english','reading',$_SESSION['year'],$_SESSION['term'])	;  
$t1mark2=subjectresult('english','test1',$_SESSION['year'],$_SESSION['term']);	  
$t2mark2=subjectresult('english','test2',$_SESSION['year'],$_SESSION['term']);	

  $speff=subjecteffort('english','spelling',$_SESSION['year'],$_SESSION['term']);	  
$leff=subjecteffort('english','language',$_SESSION['year'],$_SESSION['term']);	  
$weff=subjecteffort('english','writting',$_SESSION['year'],$_SESSION['term'])	;  
$ceff=subjecteffort('english','comprehension',$_SESSION['year'],$_SESSION['term'])	;  
$deff=subjecteffort('english','dictation',$_SESSION['year'],$_SESSION['term'])	;  
$heff=subjecteffort('english','hand_writting',$_SESSION['year'],$_SESSION['term'])	;  
$reff=subjecteffort('english','reading',$_SESSION['year'],$_SESSION['term'])	;  
$t1eff2=subjecteffort('english','test1',$_SESSION['year'],$_SESSION['term']);	  
$t2eff2=subjecteffort('english','test2',$_SESSION['year'],$_SESSION['term']);	
  //echo $mecmark;
		//class avg  
$sp=ceil(classavg('english','spelling',$_SESSION['year'],$_SESSION['term']));	  
$l=ceil(classavg('english','language',$_SESSION['year'],$_SESSION['term']));	  
$w=ceil(classavg('english','writting',$_SESSION['year'],$_SESSION['term']))	;  
$c=ceil(classavg('english','comprehension',$_SESSION['year'],$_SESSION['term'])	);  
$d=ceil(classavg('english','dictation',$_SESSION['year'],$_SESSION['term'])	);  
$h=ceil(classavg('english','hand_writting',$_SESSION['year'],$_SESSION['term']))	;  
$r=ceil(classavg('english','reading',$_SESSION['year'],$_SESSION['term']))	;  
$t12=classavg('english','test1',$_SESSION['year'],$_SESSION['term']);	  
$t22=classavg('english','test2',$_SESSION['year'],$_SESSION['term']);
$englishavg=round(($sp+$l+$w+$c+$d+$h+$t12+$t22)/6, 0);
//s avg  
$ssp=streamavg('english','spelling',$_SESSION['year'],$_SESSION['term']);	  
$sl=streamavg('english','language',$_SESSION['year'],$_SESSION['term']);	  
$sw=streamavg('english','writting',$_SESSION['year'],$_SESSION['term'])	;  
$sc=streamavg('english','comprehension',$_SESSION['year'],$_SESSION['term'])	;  
$sd=streamavg('english','dictation',$_SESSION['year'],$_SESSION['term'])	;  
$sh=streamavg('english','hand_writting',$_SESSION['year'],$_SESSION['term'])	;  
$sr=streamavg('english','reading',$_SESSION['year'],$_SESSION['term'])	;  
$st12=streamavg('english','test1',$_SESSION['year'],$_SESSION['term']);	  
$st22=streamavg('english','test2',$_SESSION['year'],$_SESSION['term']);
$englishavg1=round(($ssp+$sl+$sw+$sc+$sd+$sh+$st12+$st22)/6, 2);

//remark  
$remarks=remarks('english',$_SESSION['year'],$_SESSION['term']);	  
//overall 
$overall=remarks('overall',$_SESSION['year'],$_SESSION['term']);
//head 
$head=remarks('head',$_SESSION['year'],$_SESSION['term']);
	 //student maths average 
$averagee=ceil(studentavg('english',$_SESSION['year'],$_SESSION['term']));
	  
//EMNGLISH----------------------------------------------------------------------------------------------------------------------
  ?>	  
<center> <?php echo "<strong>ENGLISH AVERAGE $averagee%</strong>"?><table width="85%" border="0">
  <tr>
    <td width="40%"><table width="377" border="1">
  <tr bgcolor="#FFFFFF">
    <th width="242" >Subject</th>
    <th width="126" >Mark</th>
    <th width="126" >Effort</th>
    <th width="126" >Class Average</th>
    </tr> <tr>
    <td width="242" >Spelling</td>
    <td width="126" ><?php echo $spmark.'%'; ?></td>
    <td width="126" ><?php echo $speff; ?></td>
    <td width="126" ><?php echo $sp.'%'; ?></td>
    </tr> <tr>
    <td width="242" >Language</td>
    <td width="126" ><?php echo $lmark.'%'; ?></td>
    <td width="126" ><?php echo $leff; ?></td>
    <td width="126" ><?php echo $l.'%'; ?></td>
    </tr><tr>
    <td width="242" >Comprehension </td>
    <td width="126" ><?php echo $cmark.'%'; ?></td>
    <td width="126" ><?php echo $ceff; ?></td>
    <td width="126" ><?php echo $c.'%'; ?></td>
    </tr><tr>
    <td width="242" >Dictation </td>
    <td width="126" ><?php echo $dmark.'%'; ?></td>
    <td width="126" ><?php echo $deff; ?></td>
    <td width="126" ><?php echo $d.'%'; ?></td>
    </tr><tr>
    <td width="242" >Hand Writting </td>
    <td width="126" ><?php echo $hmark; ?></td>
    <td width="126" ><?php echo '--'; ?></td>
    <td width="126" ><?php echo '--'; ?></td>
    </tr><tr>
    <td width="242" >Reading</td>
    <td width="126" ><?php echo $rmark; ?></td>
    <td width="126" ><?php echo '--'; ?></td>
    <td width="126" ><?php echo '--'; ?></td>
    </tr><tr>
    <td width="242" >Written English </td>
    <td width="126" ><?php echo $wmark; ?></td>
    <td width="126" ><?php echo '--'; ?></td>
    <td width="126" ><?php echo '--'; ?></td>
    </tr><tr>
    <td width="242" ><strong>Averages</strong></td>
    <td width="126" ><?php echo "<strong>$englishavg</strong>".'%'; ?></td>
    <td width="126" >--</td>
    <td width="126" ><?php echo "<strong>$averagee</strong>".'%'; ?></td>
    </tr>
</table></td>
    <td width="60%"><table width="100%" border="1" bgcolor="#FFFFFF">
  <tr>
    <td><strong>English Remarks</strong></td>
    </tr>
  <tr>
    <td width="561"><?php echo $remarks; ?></td>
    </tr>
</table></td>
  </tr>
</table>
</center>