
    
<link rel="stylesheet" href="tabs.css" type="text/css" media="screen, projection"/>
	
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.7.custom.min.js"></script><?php
function qoutes($str){
$remove[] = "'";
$remove[] = '"';
$remove[] = "-"; // just as another example
$new = str_replace($remove, "", $str);
return $new;
}
$date = date('m/d/Y');
 $reg=$_GET['reg'];include ('opendb.php');
$name=$_GET['name'];$surname=$_GET['surname']; 
  $rs1=mysql_query("select * from class where teacher='$_SESSION[username]' ") or die(mysql_error());	  
while($row1 = mysql_fetch_array($rs1)){
		$grd = $row1['level'];
		$class = $row1['name'];}
		include ('position.php');
		?>
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
<h4>Grade <?php echo " $grd $class class"; ?> </h4>

1) Please provide us with the details we require by filling in the forms below. <br>
2) Click on [ edit ] when you want to edit the captured subject mark..<br><br>
<center>

<strong>Mark Schedule for <?php echo "$name $surname ($reg)" ?></strong></center>
<div id="page-wrap">
	<div id="tabs">
	
		<ul><?php $rs1=mysql_query("select * from final where year='$_SESSION[year]' and term='$_SESSION[term]' and ecnumber='$_SESSION[username]' ") or die(mysql_error());	  
$rowzz = mysql_num_rows($rs1);
if ($rowzz==1){ ?><li><a href="#overall">HEADS REMARKS</a></li>
			<li><a href="#maths">Maths </a></li>
			<li><a href="#english">English</a></li>			
			<li><a href="#content">Content</a></li>
            <li><a href="#other">Other Subjects</a></li>
             <li><a href="#habits">Social Habits & Attitudes</a></li>
            <!-- <li><a href="#social">Social Attitudes</a></li>-->
			<?php } else {?>
            
			<li><a href="#maths">Maths </a></li>
			<li><a href="#english">English</a></li>			
			<li><a href="#content">Content</a></li>
            <li><a href="#other">Other Subjects</a></li>
             <li><a href="#habits">Social Habits & Attitudes</a></li>
            <!-- <li><a href="#social">Social Attitudes</a></li>-->
			<li><a href="#overall">General Remarks</a></li>
			<?php } ?>
	
		</ul>
		<div id="maths" class="ui-tabs-panel">
		   [ <a href="#" onclick="move(1);">English&gt;&gt; </a> ]
		   
		   <br /><hr />
		   <p><?php include('maths.php');?>
		   
		   </p>
	  </div>

		<div id="english" class="ui-tabs-panel">
			[ <a href="#" onclick="move(0);">&lt;&lt; Maths </a> ]
			[ <a href="#" onclick="move(2);">Content &gt;&gt; </a> ]
		   <br />
		   <br /><hr />
		   <p><?php include('english.php');?>
		   
		   </p>
	  </div>
	
		<div id="content" class="ui-tabs-panel ui-tabs-hide">
			[ <a href="#" onclick="move(1);">&lt;&lt; English</a> ]
			[ <a href="#" onclick="move(3);">Other Subjects &gt;&gt; </a> ]
		    <br />
		    <br /><hr />
		    <p><?php include('content.php');?></p>
	  </div>
      <div id="other" class="ui-tabs-panel ui-tabs-hide">
			[ <a href="#" onclick="move(2);">&lt;&lt; Content</a> ]
			[ <a href="#" onclick="move(4);">Work & Social Habits &gt;&gt; </a> ]
		    <br />
		    <br /><hr />
		    <p><?php include('other.php');?></p>
	  </div><div id="habits" class="ui-tabs-panel ui-tabs-hide">
			[ <a href="#" onclick="move(3);">&lt;&lt; Art/Craft</a> ]
			[ <a href="#" onclick="move(5);">Social Attitudes &gt;&gt; </a> ]
		    <br />
		    <br /><hr />
		    <p><?php include('habits.php');?></p>
	  </div><div id="social" class="ui-tabs-panel ui-tabs-hide">
			[ <a href="#" onclick="move(4);">&lt;&lt;Work & Social Habits </a> ]
			[ <a href="#" onclick="move(6);">General Remarks&gt;&gt; </a> ]
			
		    <br />
		    <br /><hr />
		    <p><?php include('social.php');?>
  <br>
  </p>
	  </div><div id="overall" class="ui-tabs-panel ui-tabs-hide">
			[ <a href="#" onclick="move(5);">&lt;&lt;Social Attitudes  </a> ]
			
		    <br />
		    <br /><hr />
		    <p><?php include('remarkhaya.php');?></p>
	  </div>

	
	</div>
</div>




