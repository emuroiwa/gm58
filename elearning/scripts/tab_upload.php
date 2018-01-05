
    
<link rel="stylesheet" href="tabs.css" type="text/css" media="screen, projection"/>
	
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.7.custom.min.js"></script><?php
$date = date('m/d/Y');

include ('opendb.php');
   $rrrr = mysql_query("SELECT * FROM results where  session='$_SESSION[year]' and term='$_SESSION[term]' and open='yes' ")or die(mysql_query());
   if(mysql_num_rows($rrrr)>0){
	    ?>
  <script language="javascript">
 alert("RESULTS HAVE BEEN PUBLISHED FOR THIS TERM");
 location = 'index.php?page=students.php'
  </script>
  <?php
  exit;
   
	   }else{
    
  $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}?>
<script type="text/javascript">
	function move(index){
		var $tabs = $('#tabs').tabs();
	   $tabs.tabs('select', index);
	   return false;
	}

	$(function() {

		var $tabs = $('#tabs').tabs();

		$(".ui-tabs-panel").each(function(i){

		  var totalSize = $(".ui-tabs-panel").size() - 1;
		  
			 
		  if (i != totalSize) {
			  next = i + 2;
			 // $(this).append("<a href='#' class='next-tab mover' rel='" + next + "'>Next Page &#187;</a>");
		  }
  
		  if (i != 0) {
			  prev = i;
			  //$(this).append("<a href='#' class='prev-tab mover' rel='" + prev + "'>&#171; Prev Page</a>");
		  }
	
		});

		$('.next-tab, .prev-tab').click(function() { 
			   $tabs.tabs('select', $(this).attr("rel"));
			   return false;
		   });
   

	}); 
</script>


<script type="text/javascript">
	document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>


<style type="text/css">
<!--
.style1 {color: #003399}
-->
</style>
<center><h4>Grade <?php echo " $grd $class class"; ?> </h4></center>

1) Download and fill out the excel document ..<br>
2) Click on browse and locate the excel document ..<br>
3) Once excel file has been selected click "Upload File" to submit student marks..
<div id="page-wrap">
	<div id="tabs">
	
		<ul>
			<li><a href="#all">All Subjects</a></li>
	
             <li><a href="#habits">Social Habits And Attitudes</a></li>
			<!--<li><a href="#remarks">All Remarks</a></li>-->
			
	
		</ul>
		<div id="all" class="ui-tabs-panel">
		   
		   <hr />
		   <p><?php include('download.php');?>
		   
		   </p>
	  </div>

		<div id="habits" class="ui-tabs-panel">
			   <hr />
		   <p><?php include('habits_all.php');?>
		   
		   </p>
	  </div>
	
		<div id="remarks" class="ui-tabs-panel ui-tabs-hide">
		   <hr />
		    <p><?php include('remarks_all.php');?></p>
	  </div>
      
	
	</div>
</div>
<?php } ?>



