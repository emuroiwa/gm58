<link rel="stylesheet" href="tabs.css" type="text/css" media="screen, projection"/>

<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.7.custom.min.js"></script><?php
$date = date('m/d/Y');
 $reg=$_GET['reg'];
$name=$_GET['name'];
$surname=$_GET['surname'];
$datewritten=$_GET['date'];
$description=$_GET['de']; 
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
<h3>Grade <?php echo " $grd $class class"; ?> </h3>

1) Please click subject tab and click the particular subject to update results below. <br>
2) Click on [ edit ] when you want to edit the captured subject mark.<br>




<div id="page-wrap">
	<div id="tabs">
	
		<ul>
			<li><a href="#maths">Maths </a></li>
			<li><a href="#english">English</a></li>			
			<li><a href="#content">Content</a></li>
			
	
		</ul>
		<div id="maths" class="ui-tabs-panel">
		   [ <a href="#" onclick="move(1);">English&gt;&gt; </a> ]
		   <br />
		   <br /><hr />
		   <p><?php include('mathsnew.php');?>
		   
		   </p>
	  </div>

		<div id="english" class="ui-tabs-panel">
			[ <a href="#" onclick="move(0);">&lt;&lt; Maths </a> ]
			[ <a href="#" onclick="move(2);">Content &gt;&gt; </a> ]
		   <br />
		   <br /><hr />
		   <p><?php include('englishnew.php');?>
		   
		   </p>
	  </div>
	
		<div id="content" class="ui-tabs-panel ui-tabs-hide">
			[ <a href="#" onclick="move(1);">&lt;&lt; English</a> ]
			
		    <br />
		    <br /><hr />
		    <p><?php include('contentnew.php');?></p>
	  </div>
	
	</div>
</div>




