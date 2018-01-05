<?php
error_reporting(0);

	include ('aut.php'); include ('opendb.php'); 
	$session = date('Y');
$resulterm = mysql_query("SELECT * FROM term ")or die(mysql_query());
 while($rowterm = mysql_fetch_array($resulterm, MYSQL_ASSOC))
	  	  
{
$term=$rowterm['term'];
}$_SESSION['year'] = $session;
$_SESSION['term'] = $term;

?><!DOCTYPE html>
<html dir="ltr" lang="en-US"><head><!-- Divine baba -->
    <meta charset="utf-8">
    <title>Student Portal</title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
<link href="../images/logo.png" rel="icon" type="image">
    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="style.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="style.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="style.responsive.css" media="all">
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lobster|Cabin&amp;subset=latin">
<noscript><meta http-equiv="refresh" content="1;url=error.html"></noscript>

    <script src="jquery1.js"></script>
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
<h2 class="art-slogan" data-left="97.22%">e-Schools Software Solution</h2>



            </div>

              
</header>
<nav class="art-nav clearfix">
    <ul class="art-hmenu"><li><a href="index.php" class="active">Home</a></li>
    <li><a href="index.php?page=cw.php" class="active">Marks Book</a></li>
    <li><a href="index.php?page=overall.php" class="active">Online Progress Report</a>
   <ul><li><a href="index.php?page=test2.php" class="active">Progress Report Breakdown</a></li><li><a href="index.php?page=search.php" class="active">Search Progress Report</a></li></ul></li>

  <li><a href="" class="active">Settings</a><ul>
<li><a href="index.php?page=changepass.php" class="active">Change Password</a></li>
<li><a href="../logout.php" class="active">LOGOUT</a></li></ul></li></ul> 
    </nav>
<div class="art-sheet clearfix">
            <div class="art-layout-wrapper clearfix">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content clearfix"><article class="art-post art-article">
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><?php echo "Welcome ($_SESSION[reg]) $_SESSION[name]&nbsp;&nbsp; To [Term $_SESSION[term] Year $_SESSION[year]]" ?></h2>
                                                            
                                    </div>
                                <div class="art-postcontent art-postcontent-0 clearfix"><p><?php
$pg = @$_REQUEST['page'];
if($pg != "" && file_exists(dirname(__FILE__)."/".$pg)){
require(dirname(__FILE__)."/".$pg);
}elseif(!file_exists(dirname(__FILE__)."/".$pg))
include_once(dirname(__FILE__)."/404.php");
else{
include_once("details.php");
}
?>	<div id="backtotop">Scroll to Top</div>  </p><br></div>


</article></div>
                    </div>
                </div>
            </div><footer class="art-footer clearfix">
<p><span style="text-shadow: rgb(23, 23, 23) 0px 0px 12px;">e-Schools Software Solution</span></p>
<p>Powered By&nbsp;<a href="https://www.facebook.com/divinedevelopers4" target="_blank" title="Muroiwa Chibanda">Divine Developers</a></p>
</footer>

   


</body></html>