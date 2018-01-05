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


  <div id="page-wrap">
	<div id="tabs">
	
		<ul>
			<li> <a href="../scripts/print/printstd.php?reg=<?php echo $_SESSION['reg']; ?>&name=<?php echo $_SESSION['name']; ?>" target="_blank"><strong>REPORT CARD</strong></a></li>
			 

	
		</ul>
		

	
	</div>
</div><center>Click here to <a href="../scripts/print/printstd1.php?reg=<?php echo $_SESSION['reg']; ?>&name=<?php echo $_SESSION['name']; ?>" target="_blank"><strong>PRINT REPORT CARD</strong><!--<img src="../scripts/images/postprinticon.png"</a>--></a></center>
<?php } ?>



