<?php error_reporting(0);
include 'resultfunction.php';
session_start();
include 'opendb.php'?>
 <?php
		 function x($mark,$type){
			if($mark=='Very Good' and $type=='V.Good')
		{
			$effort="<strong>X</strong>";}
					elseif($mark=='Good' and $type=='Good')
		{
			$effort="<strong>X</strong>";}	
				elseif($mark=='Average' and $type=='Average')
		{
			$effort="<strong>X</strong>";}
				elseif($mark=='Poor' and $type=='Poor')
		{
			$effort="<strong>X</strong>";}
				elseif($mark=='Very Poor' and $type=='V.Poor')
		{
			$effort="<strong>X</strong>";}
				
				else{$effort=" ";}
				return $effort;}		 
		 ?>
<?php
  //other-----------------------------------------------------------------------------------------------------------------------
  //subject mark effort
  $extra_mark=subjectresult('other','Extra_Mural_Actvites',$_SESSION['year'],$_SESSION['term']);	  
  $extra_eff=subjecteffort('other','Extra_Mural_Actvites',$_SESSION['year'],$_SESSION['term']);	  
$extra_remarks=remarks('Extra_Mural_Actvites',$_SESSION['year'],$_SESSION['term']);	  
  //other-----------------------------------------------------------------------------------------------------------------------
  //subject mark effort
  $art_mark=subjecteffort('other','Art_Craft',$_SESSION['year'],$_SESSION['term']);	  
  $compmark=subjecteffort('other','computers',$_SESSION['year'],$_SESSION['term']);	  
//remark  
$art_remarks=remarks('Art_Craft',$_SESSION['year'],$_SESSION['term']);	
$comp_remarks=remarks('computers',$_SESSION['year'],$_SESSION['term']);	  
//-----------------------------------------------------------------------------------------------------------------------
  //subject mark effort
  $shona_mark=subjectresult('other','shona',$_SESSION['year'],$_SESSION['term']);	  
  $shona_eff=subjecteffort('other','shona',$_SESSION['year'],$_SESSION['term']);	  
//remark
$shona_remarks=remarks('shona',$_SESSION['year'],$_SESSION['term']);
    
	 //student shona average 
$shona_avg=ceil(classavg('other','shona',$_SESSION['year'],$_SESSION['term']));	  
$shona_stream=ceil(streamavg('other','shona',$_SESSION['year'],$_SESSION['term']));	  
$shona_averagee=ceil(studentavg('shona',$_SESSION['year'],$_SESSION['term']));
	//--------------------------------------------------------------------------------------------------------------------  
	
  //subject mark effort
  $scri_mark=subjecteffort('content','Scripture',$_SESSION['year'],$_SESSION['term']);	  
$sci_mark=subjecteffort('content','Science',$_SESSION['year'],$_SESSION['term']);	  
$ss_mark=subjecteffort('content','Social_Studies',$_SESSION['year'],$_SESSION['term'])	;  

//remark  
$content_remarks=remarks('content',$_SESSION['year'],$_SESSION['term']);	  
	
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
$t12=ceil(classavg('english','test1',$_SESSION['year'],$_SESSION['term']));	  
$t22=ceil(classavg('english','test2',$_SESSION['year'],$_SESSION['term']));
$englishavgg=ceil(($sp+$l+$w+$c+$d+$h+$t12+$t22)/6);
$englishavg=ceil($englishavgg);
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
$englishavg1=ceil(($ssp+$sl+$sw+$sc+$sd+$sh+$st12+$st22)/6);

//remark  
$english_remarks=remarks('english',$_SESSION['year'],$_SESSION['term']);	  

$english_averagee=ceil(studentavg('english',$_SESSION['year'],$_SESSION['term']));
	  

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
$mathsavg=ceil(($mec+$men+$prob+$t1+$t2)/5);
$mathsavg=ceil($mathsavg);
//s avg  
$smec=streamavg('maths','mechanical',$_SESSION['year'],$_SESSION['term']);	  
$smen=streamavg('maths','mental',$_SESSION['year'],$_SESSION['term']);	  
$sprob=streamavg('maths','problems',$_SESSION['year'],$_SESSION['term'])	;  
$st1=streamavg('maths','test1',$_SESSION['year'],$_SESSION['term']);	  
$st2=streamavg('maths','test2',$_SESSION['year'],$_SESSION['term']);
$mathsavg1=ceil(($smec+$smen+$sprob+$st1+$st2)/5);

//remark  
$maths_remarks=remarks('maths',$_SESSION['year'],$_SESSION['term']);	  

$maths_averagee=ceil(studentavg('maths',$_SESSION['year'],$_SESSION['term']));
	$total_avg=ceil(($english_averagee+$maths_averagee+$shona_averagee)/3);
	$total_stream=ceil(($mathsavg1+$englishavg1+$shona_stream)/3);
	$total_class=ceil(($mathsavg+$shona_avg+$englishavg)/3);  
  ?>
 
