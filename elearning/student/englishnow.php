<?php
  //english-----------------------------------------------------------------------------------------------------------------------
  //subject mark effort
  $spmark=subjectresult('english','H/W Spelling',$_SESSION['year'],$_SESSION['term']);	  
$lmark=subjectresult('english','H/W Language',$_SESSION['year'],$_SESSION['term']);	  
$wmark=subjectresult('english','writting',$_SESSION['year'],$_SESSION['term'])	;  
$cmark=subjectresult('english','comprehension',$_SESSION['year'],$_SESSION['term'])	;  
$dmark=subjectresult('english','dictation',$_SESSION['year'],$_SESSION['term'])	;  
$hmark=subjectresult('english','hand_writting',$_SESSION['year'],$_SESSION['term'])	;  
$rmark=subjectresult('english','reading',$_SESSION['year'],$_SESSION['term'])	;  
$t1mark2=subjectresult('english','C/W Language',$_SESSION['year'],$_SESSION['term']);	  
$t2mark2=subjectresult('english','Classwork',$_SESSION['year'],$_SESSION['term']);	

  $speff=subjectask('english','H/W Spelling',$_SESSION['year'],$_SESSION['term']);	  
$leff=subjectask('english','H/W Language',$_SESSION['year'],$_SESSION['term']);	  
$weff=subjectask('english','writting',$_SESSION['year'],$_SESSION['term'])	;  
$ceff=subjectask('english','comprehension',$_SESSION['year'],$_SESSION['term'])	;  
$deff=subjectask('english','dictation',$_SESSION['year'],$_SESSION['term'])	;  
$heff=subjectask('english','hand_writting',$_SESSION['year'],$_SESSION['term'])	;  
$reff=subjectask('english','reading',$_SESSION['year'],$_SESSION['term'])	;  
$t1eff2=subjectask('english','C/W Language',$_SESSION['year'],$_SESSION['term']);	  
$t2eff2=subjectask('english','Classwork',$_SESSION['year'],$_SESSION['term']);	
  //echo $mecmark;
		//class avg  
$sp=subjectotal('english','H/W Spelling',$_SESSION['year'],$_SESSION['term']);	  
$l=subjectotal('english','H/W Language',$_SESSION['year'],$_SESSION['term']);	  
$w=subjectotal('english','writting',$_SESSION['year'],$_SESSION['term'])	;  
$c=subjectotal('english','comprehension',$_SESSION['year'],$_SESSION['term'])	;  
$d=subjectotal('english','dictation',$_SESSION['year'],$_SESSION['term'])	;  
$h=subjectotal('english','hand_writting',$_SESSION['year'],$_SESSION['term'])	;  
$r=subjectotal('english','reading',$_SESSION['year'],$_SESSION['term'])	;  
$t12=subjectotal('english','C/W Language',$_SESSION['year'],$_SESSION['term']);	  
$t22=subjectotal('english','Classwork',$_SESSION['year'],$_SESSION['term']);
$englishavg=round(($sp+$l+$w+$c+$d+$h+$t12+$t22)/6, 2);
//s avg  
$ssp=streamavg('english','H/W Spelling',$_SESSION['year'],$_SESSION['term']);	  
$sl=streamavg('english','H/W Language',$_SESSION['year'],$_SESSION['term']);	  
$sw=streamavg('english','writting',$_SESSION['year'],$_SESSION['term'])	;  
$sc=streamavg('english','comprehension',$_SESSION['year'],$_SESSION['term'])	;  
$sd=streamavg('english','dictation',$_SESSION['year'],$_SESSION['term'])	;  
$sh=streamavg('english','hand_writting',$_SESSION['year'],$_SESSION['term'])	;  
$sr=streamavg('english','reading',$_SESSION['year'],$_SESSION['term'])	;  
$st12=streamavg('english','C/W Language',$_SESSION['year'],$_SESSION['term']);	  
$st22=streamavg('english','Classwork',$_SESSION['year'],$_SESSION['term']);
$englishavg1=round(($ssp+$sl+$sw+$sc+$sd+$sh+$st12+$st22)/6, 2);

//remark  
$remarks=remarks('english',$_SESSION['year'],$_SESSION['term']);	  
//overall 
$overall=remarks('overall',$_SESSION['year'],$_SESSION['term']);
//head 
$head=remarks('head',$_SESSION['year'],$_SESSION['term']);
	 //student maths average 
$averagee=studentavg('english',$_SESSION['year'],$_SESSION['term']);
	  
//EMNGLISH----------------------------------------------------------------------------------------------------------------------
  ?>	  
  <hr> Symbols:  A=Fluent and attacks new words with ease  <br>
B=Fluent but not attacking new words <br>
 C=Not fluent but recognises new words <br>
 D=Struggles with fluency and new word recognition
<hr> <center><?php echo "<strong>Marks for $_GET[date]</strong>"?><table width="377" border="1">
  <tr bgcolor="#FFFFFF">
    <th width="242" >Subject</th>
    <th width="126" >Mark</th>
    <th width="126" >Task</th>
    <th width="126" >Out Of</th>
   
  </tr> <tr>
    <td width="242" >H/W Spelling</td>
    <td width="126" ><?php echo $spmark ?></td>
    <td width="126" ><?php echo $speff; ?></td>
    <td width="126" ><?php echo $sp ?></td>
  </tr> <tr>
    <td width="242" >H/W Language</td>
    <td width="126" ><?php echo $lmark ?></td>
    <td width="126" ><?php echo $leff; ?></td>
    <td width="126" ><?php echo $l ?></td>
  </tr><tr>
    <td width="242" >Comprehension </td>
    <td width="126" ><?php echo $cmark ?></td>
    <td width="126" ><?php echo $ceff; ?></td>
    <td width="126" ><?php echo $c ?></td>
  </tr><tr>
    <td width="242" >Dictation </td>
    <td width="126" ><?php echo $dmark ?></td>
    <td width="126" ><?php echo $deff; ?></td>
    <td width="126" ><?php echo $d ?></td>
  </tr><tr>
    <td width="242" >Hand Writting </td>
    <td width="126" ><?php echo $hmark; ?></td>
    <td width="126" ><?php echo $heff; ?></td>
    <td width="126" ><?php echo $h; ?></td>
  </tr><tr>
    <td width="242" >Reading</td>
    <td width="126" ><?php echo $rmark; ?></td>
    <td width="126" ><?php echo $reff; ?></td>
    <td width="126" ><?php echo $r; ?></td>
  </tr><tr>
    <td width="242" >Written English </td>
    <td width="126" ><?php echo $wmark; ?></td>
    <td width="126" ><?php echo $weff; ?></td>
    <td width="126" ><?php echo $w; ?></td>
  </tr><tr>
    <td width="242" >C/W Language</td>
    <td width="126" ><?php echo $t1mark2 ?></td>
    <td width="126" ><?php echo $t1eff2; ?></td>
    <td width="126" ><?php echo $t12 ?></td>
  </tr><tr>
    <td width="242" >Classwork</td>
    <td width="126" ><?php echo $t2mark2 ?></td>
    <td width="126" ><?php echo $t2eff2; ?></td>
    <td width="126" ><?php echo $t22 ?></td>
  </tr>
</table>
</center>