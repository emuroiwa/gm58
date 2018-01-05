
<link rel="stylesheet" href="tabs.css" type="text/css" media="screen, projection"/>
	
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.7.custom.min.js"></script><?php
$date = date('m/d/Y');
 $reg=$_GET['reg'];include ('opendb.php');
$name=$_GET['name'];$surname=$_GET['surname']; 
  $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
		$rs=mysql_query("select * from results where session='$_SESSION[year]' and term='$_SESSION[term]' and open='yes' limit 1") or die(mysql_error());	  
$rows = mysql_num_rows($rs);?>
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
<h4>Grade <?php echo " $_GET[level] $_GET[class] class"; ?> </h4>


<center>

<strong> <?php if ($rows==0)	{echo "Overall Progress Report for $name $surname ($reg)";}else {
	echo "Published results for $name $surname ($reg)";} ?></strong></center>
<div id="page-wrap">
	<div id="tabs">
	
		<ul>
			<li><a href="#report">Students Report </a></li>
			<li><a href="#remark">Enter Remarks</a></li><?php if ($rows==0)	{?>		
			<li><a href="#correct">Progress Report Corrections</a></li><?php } ?>
            
			
	
		</ul>
		<div id="report" class="ui-tabs-panel">
		   [ <a href="#" onclick="move(1);">Head's Remark&gt;&gt; </a> ]
		   
		   <br /><hr />
		   <p><?php include('head_report.php');?>
		   
		   </p>
	  </div>

		<div id="remark" class="ui-tabs-panel">
			[ <a href="#" onclick="move(0);">&lt;&lt; Student Report </a> ]
			[ <a href="#" onclick="move(2);">Corrections If any &gt;&gt; </a> ]
		   <br />
		   <br /><hr />
		   <p><?php include('head_remark.php');?>
		   
		   </p>
	  </div>
	
		<div id="correct" class="ui-tabs-panel ui-tabs-hide">
			[ <a href="#" onclick="move(1);">&lt;&lt; Remarks</a> ]
			
		    <br />
		    <br /><hr />
		    <p><?php include('head_correct.php');?></p>
	  </div>
     

	
	</div>
</div>




