<?php
error_reporting(0);

	include ('aut.php');
	 include ('opendb.php');
	 include ('../license_check.php');
	 
	  include ('changeclass.php');
	  if(isset($_GET['name'])){
		  $name=$_GET['name']; 
		  $title="$name $_GET[surname]  ($_GET[ec]$_GET[reg] )";
		  }if(!isset($_GET['name'])){
		  $title="Trial Version";
		  }
	  
?><!DOCTYPE html>
<html dir="ltr" lang="en-US"><head><!-- Created by divine-->
    <meta charset="utf-8">
    <title><?php echo "$title"; ?></title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
<link href="../images/logo.png" rel="icon" type="image">
    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="head/style.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="style.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="head/style.responsive.css" media="all">
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lobster|Cabin&amp;subset=latin">

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
    <script src="head/jquery.js"></script>
    <script src="head/script.js"></script>
    <script src="head/script.responsive.js"></script>


</head>
<body>
<div id="art-main">
<header class="art-header clearfix">


    <div class="art-shapes">
<h1 class="art-headline" data-left="15.78%">
    <a href="#">Midlands Christian School</a>
</h1>
<h2 class="art-slogan" data-left="97.35%">e-Schools Software Solution DEMO</h2>



            </div>

                <?php $rs1=mysql_query("select * from correct where session='$_SESSION[year]' and term='$_SESSION[term]' and status='pending' ") or die(mysql_error());	  
$rowzz = mysql_num_rows($rs1); ?>
                    
</header>
<nav class="art-nav clearfix">
    <ul class="art-hmenu"><li><a href="head.php" class="active">Home</a></li>
<li><a href="head.php?page=head_class.php" class="active">Finalised Reports</a><ul>
<li><a href="head.php?page=pending.php" class="active">Pending Reports</a></li></ul></li><?php if($rowzz>0) { ?> 
<li><a href="head.php?page=correctioncheck.php" class="active">Pending Corrections (<?php echo $rowzz; ?>)</a></li>
<?php }?>
<li><a href="#" class="active">Performance</a><ul>
<li><a href="head.php?page=performance_classqq.php" class="active">Class Performance</a></li>
<li><a href="head.php?page=performance_streamqq.php" class="active">Stream Performance</a></li>
<li><a href="head.php?page=head_classjdshj.php" class="active">School Performance</a></li>
</ul></li>
<li><a href="" class="active">Settings</a><ul>
<li><a href="head.php?page=changepass.php" class="active">Change Password</a></li>
<li><a href="../logout.php" class="active">LOGOUT</a></li></ul></li></ul> 
    </nav>
<div class="art-sheet clearfix">
            <div class="art-layout-wrapper clearfix">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content clearfix"><article class="art-post art-article">
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><?php echo "Welcome!!  $_SESSION[name]&nbsp;&nbsp; To [Term $_SESSION[term] Year $_SESSION[year]]" ?></h2>
                                                            
                                    </div>
                                <div class="art-postcontent art-postcontent-0 clearfix"> <?php
$pg = @$_REQUEST['page'];
if($pg != "" && file_exists(dirname(__FILE__)."/".$pg)){
require(dirname(__FILE__)."/".$pg);
}elseif(!file_exists(dirname(__FILE__)."/".$pg))
include_once(dirname(__FILE__)."/404.php");
else{
include_once("home.php");
}
?>  <div id="backtotop" align="right">Scroll to Top</div>   </div>


</article></div>
                    </div>
                </div>
            </div><footer class="art-footer clearfix">
<p><span style="text-shadow: rgb(23, 23, 23) 0px 0px 12px;">e-Schools Software Solution</span></p>
<p>Powered By&nbsp;<a href="https://www.facebook.com/divinedevelopers4" target="_blank" title="Muroiwa Chibanda">Divine Developers</a></p>
</footer>

    </div>
    
</div>


</body></html>