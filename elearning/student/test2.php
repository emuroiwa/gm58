<link rel="stylesheet" href="tabs.css" type="text/css" media="screen, projection"/>

<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.7.custom.min.js"></script><?php 
 
  
  $result111 = mysql_query("SELECT * FROM results ,student ,student_class WHERE results.reg = student.reg AND results.term ='$_SESSION[term]' AND results.session ='$_SESSION[year]' AND results.reg = '$_SESSION[reg]'  AND results.`open` = 'yes' AND student.reg = student_class.student and subject_id='maths' ")or die(mysql_query());
     $rows1 = mysql_num_rows($result111);
	 if($rows1==0){
		 
		 echo "<center><strong><font color='red'><br><br><br><br><br>Your results for year  $_SESSION[year] and term $_SESSION[term] are currently being proccessed . Please keep checking........<br><br><br><br><br><br><br><br><br><br><br>
</font></strong></center>";
		 exit;
		 }
		 else{

  
  
  
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

1) Click on the Tabs to view results for a particular subject, for example - click on the [ Content ] to View content results.<br>

            2) Click here to <a href="../scripts/print/printstd1.php?reg=<?php echo $_SESSION['reg']; ?>&name=<?php echo $_SESSION['name']; ?>" target="_blank"><strong>PRINT REPORT CARD</strong><!--<img src="../scripts/images/postprinticon.png"</a>--></a>
  <hr> <strong>Symbols:  A=Excellent  B=Good  C=Satisfactory  D=Poor  E=Weak/Unsatisfactory<br>Note:-Attainment is an assessment of child's attainment in relation to the whole class: Effort is an assessment as an individual.
</strong><hr> <div id="page-wrap">
	<div id="tabs">
	
		<ul>
			<li><a href="#maths">Maths </a></li>
			<li><a href="#english">English</a></li>			
			<li><a href="#content">Content</a></li>
            <li><a href="#shona">Shona</a></li>
            <li><a href="#other">Other</a></li> 
            <li><a href="#behave">Behaviour</a></li> 
            <li><a href="#social">Social Attitudes</a></li> 
            <li><a href="#extra">Extra Mural Activities</a></li>

			 

	
		</ul>
		<div id="maths" class="ui-tabs-panel">
		   [ <a href="#" onclick="move(1);">English&gt;&gt; </a> ]
		   <br />
		   <br /><hr />
		   <p><?php include('mathsresult.php');?>
		   
		   </p>
	  </div>

		<div id="english" class="ui-tabs-panel">
			[ <a href="#" onclick="move(0);">&lt;&lt; Maths </a> ]
			[ <a href="#" onclick="move(2);">Content &gt;&gt; </a> ]
		   <br />
		   <br /><hr />
		   <p><?php include('englishresult.php');?>
		   
		   </p>
	  </div>
	
<div id="content" class="ui-tabs-panel ui-tabs-hide">
			[ <a href="#" onclick="move(1);">&lt;&lt; English</a> ]
			[ <a href="#" onclick="move(3);">Shona &gt;&gt; </a> ]
		    <br />
		    <br /><hr />
    <p><?php include('contentresult.php');?>
		   </p>
    </div><div id="shona" class="ui-tabs-panel ui-tabs-hide">
			[ <a href="#" onclick="move(2);">&lt;&lt; Content</a> ]
			[ <a href="#" onclick="move(4);">Computers And Art &gt;&gt; </a> ]
		    <br />
		    <br /><hr />
		    <p><?php include('shona.php');?></p>
	  </div>
<div id="other" class="ui-tabs-panel ui-tabs-hide">
			[ <a href="#" onclick="move(3);">&lt;&lt; Shona</a> ]
			[ <a href="#" onclick="move(5);">Pupil Behaviour &gt;&gt; </a> ]
		    <br />
		   
		    <p><?php include('other.php');?></p>
	  </div>
       <div id="behave" class="ui-tabs-panel ui-tabs-hide">
			[ <a href="#" onclick="move(4);">&lt;&lt; Shona</a> ]
			[ <a href="#" onclick="move(6);">Social Attitudes &gt;&gt; </a> ]
		    <br />
		   
		    <p><?php include('behave.php');?></p>
	  </div> 
<div id="social" class="ui-tabs-panel ui-tabs-hide">
			[ <a href="#" onclick="move(5);">&lt;&lt; Work and Social Habits</a> ]
			[ <a href="#" onclick="move(7);">Extra Mural Actvities  &gt;&gt; </a> ]
		    <br />
		   
		    <p><?php include('behave1.php');?></p>
	  </div>
<div id="extra" class="ui-tabs-panel ui-tabs-hide">
			[ <a href="#" onclick="move(6);">&lt;&lt; Work and Social Habits</a> ]
			
		    <br />
		    <br /><hr />
		    <p><?php include('extra.php');?></p>
	  </div>
	
	</div>
</div>
<?php } ?>



