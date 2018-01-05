<?php

 include 'resultfunction1.php'?>
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
  <?php
 
  $rs1=mysql_query("select * from class where teacher='7777' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
		$rs=mysql_query("select * from results where session='$_SESSION[year]' and term='$_SESSION[term]' and open='yes' limit 1") or die(mysql_error());	  
$rows = mysql_num_rows($rs);
 $student= mysql_query("SELECT * FROM class,student_class WHERE class.`name` = student_class.class AND class.`level` = student_class.`level` AND class.teacher = '7777'");
while($row = mysql_fetch_array($student, MYSQL_ASSOC))
	  	  {$reg=$row['student'];
?>
  <center><?php echo "<strong>MATHS AVERAGE $averagee%</strong>"?><table width="84%" border="0">
  <tr>
    <td width="71%"><table width="377" border="1">
  <tr bgcolor="#FFFFFF">
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
  </tr><tr>
    <td width="242" ><strong>Averages</strong></td>
    <td width="126" ><?php echo "<strong>$averagee</strong>".'%'; ?></td>
    <td width="126" >--</td>
    <td width="126" ><?php echo "<strong>$mathsavg</strong>".'%'; ?></td>
    <td width="126" ><?php echo "<strong>$mathsavg1</strong>".'%'; ?></td>
  </tr>
</table>
</td>
    <td width="29%"><table width="80%" border="1" bgcolor="#FFFFFF">
  <tr>
    <td width="200"><strong>Maths Remarks</strong></td>
    </tr>
  <tr>
    <td><?php echo $remarks; ?></td>
    </tr>
</table></td>
  </tr>
</table>
<?php } ?>

</center>