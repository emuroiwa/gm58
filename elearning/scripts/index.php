<?php
error_reporting(0);

	include ('aut.php');
	 include ('opendb.php');
	 include ('../license_check.php');
	 
	 include ('changeclass.php');
	  if(isset($_GET['name'])){
		  $name=$_GET['name']; 
		  $title="$name $_GET[surname]  ($_GET[reg] )";
		  }if(!isset($_GET['name'])){
		  $title="Trial Version";
		  }
	  
?><!DOCTYPE html>
<html dir="ltr" lang="en-US"><head><!-- Created isu-->
    <meta charset="utf-8">
    <title><?php echo "$title"; ?></title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
<link href="../images/logo.png" rel="icon" type="image">
    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="style.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="style.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="style.responsive.css" media="all">
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lobster|Cabin&amp;subset=latin">

<link rel="stylesheet" href="tabs.css" type="text/css" media="screen, projection"/>
<noscript><meta http-equiv="refresh" content="1;url=../error.html"></noscript>

<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.7.custom.min.js"></script>


<link rel="stylesheet" href="global.css" type="text/css">
    <script src="jquery.js"></script>
    <script src="script.js"></script>
    <script src="script.responsive.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
	$(window).scroll(function() {
		if($(this).scrollTop() != 0) {
			$('#backtotop').fadeIn();	
		} else {
			$('#backtotop').fadeOut();
		}
	});
 
	$('#backtotop').click(function() {
		$('body,html').animate({scrollTop:0},800);
	});	
});
</script>

</head>
<body>
<div id="art-main">
<header class="art-header clearfix">


    <div class="art-shapes">
<h1 class="art-headline" data-left="15.78%">
    <a href="#">Midlands Christian School</a>
</h1>
<h2 class="art-slogan" data-left="97.22%">e-Schools Software Solution DEMO</h2>



            </div>
<?php $rs1=mysql_query("SELECT
*
FROM `class`,student_class
WHERE
class.`name` = student_class.class AND
class.`level` = student_class.`level` AND

class.teacher = '$_SESSION[username]' ") or die(mysql_error());	  

 $check=mysql_query("SELECT
*
FROM `class`,results
WHERE
class.`name` = results.class AND
results.`level` = class.`level` and teacher='$_SESSION[username]'") or die(mysql_error());

?>
                
                    
</header>
<nav class="art-nav clearfix">
    <ul class="art-hmenu"><li><a href="index.php" class="active">Home</a></li><?php if($_SESSION['access'] == 1) { ?> 
    <li><a href="index.php?page=createstudent.php" class="active">Admissions</a><ul>
    <li><a href="index.php?page=view.php" class="active">View Student</a></li> 
      <li><a href="index.php?page=transfer.php" class="active">Student Transfers</a></li></ul></li>
<li><a href="#" class="active">Staff </a><ul>
<li><a href="index.php?page=creates.php" class="active">Add Staff </a><li>
<li><a href="index.php?page=manage.php" class="active">Manage Staff</a></li>
</ul>
</li>
<li><a href="#" class="active">Class Settings</a><ul>
<li><a href="index.php?page=assclass.php" class="active">Assign Class</a></li>
<li><a href="index.php?page=assclass2.php" class="active">Assign Other Class</a></li>
<li><a href="index.php?page=deassclass.php" class="active">Deassign Class</a></li></ul></li>

<?php } ?><?php if($_SESSION['access'] ==3 ){ ?> 

<li><a href="index.php?page=marksbook.php" class="active">Marks Book</a><ul>
<li><a href="index.php?page=coursework.php" class="active">View Marks Book</a></li></ul></li>
<li><a href="index.php?page=tab_upload.php" class="active">Mark Schedule</a></li>
<?php }?>
<?php if($_SESSION['access'] ==3 &&  mysql_num_rows($check)>0 && mysql_num_rows($rs1)>0) { ?> 
<li><a href="index.php?page=students.php" class="active">View Results</a></li>
<!--<li><a href="index.php?page=pos.php" class="active">View Positions</a></li>-->
<?php }?>

</ul> 
    </nav>
<div class="art-sheet clearfix">
            <div class="art-layout-wrapper clearfix">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-sidebar1 clearfix"><div class="art-vmenublock clearfix">
        <div class="art-vmenublockheader">
           <h4> Navigation</h4>
        </div>
        <div class="art-vmenublockcontent">
<ul class="art-vmenu"><li><a href="index.php" class="active">Home</a></li>
<?php if($_SESSION['access'] == 2) { ?>
<script language="javascript">
  location = 'head.php'
  </script>

    
 

  
<?php   }if($_SESSION['access'] ==3) { ?> 

<?php   if($_SESSION['term'] == 7) {?>
<li><a href="index.php?page=coursework.php" class="active">Mark Schedule</a></li>
<?php }} if($_SESSION['access'] == 1) { ?> 

<!--
<li><a href="index.php?page=suspend_users.php" class="active">Suspend Staff</a></li>
<li><a href="index.php?page=suspend_student.php" class="active">Suspend Students</a></li>
<li><a href="index.php?page=unsuspend_users.php" class="active">Unsuspend Staff</a></li>-->
<!--<li><a href="index.php?page=unsuspend_std.php" class="active">Unsuspend Students</a></li>
--><li><a href="index.php?page=termz.php" class="active">New Term</a></li>
<li><a href="index.php?page=backup.php" class="active">BACK UP</a></li>
  <?php } ?>
    <li><a href="index.php?page=changepass.php" class="active">Settings</a></li>
     <li><a href="../guide.docx">Download Guide</a></li>
     <li><a href="../logout.php">LOGOUT</a></li> </ul>           
        </div>
</div></div>
                        <div class="art-layout-cell art-content clearfix"><article class="art-post art-article">
                               
                                <div class="art-postcontent art-postcontent-0 clearfix"><p>
                                
                                 <?php
$pg = @$_REQUEST['page'];
//echo $_SESSION['access'];
if($pg != "" && file_exists(dirname(__FILE__)."/".$pg)){
require(dirname(__FILE__)."/".$pg);
}elseif(!file_exists(dirname(__FILE__)."/".$pg))
include_once(dirname(__FILE__)."/404.php");
else{
include_once("home.php");
}
?>   
                                
                                
                             		<div id="backtotop">Scroll to Top</div>   <br></p></div>


</article></div>
                    </div>
                </div>
            </div><footer class="art-footer clearfix">
<p><span style="text-shadow: rgb(23, 23, 23) 0px 0px 12px;">e-Schools Software Solution DEMO</span></p>
<p>Powered By&nbsp;<a href="https://www.facebook.com/divinedevelopers4" target="_blank" title="Muroiwa Chibanda">Divine Developers</a></p>
</footer>

   


</body></html>