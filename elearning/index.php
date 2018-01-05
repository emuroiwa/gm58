<?php 
error_reporting(0);
include 'opendb.php';
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
		echo '<center><img src="images/oops.jpg" >';
		echo '<br>
<br>
<br>
<a href="http://www.mozilla.org/en-US/firefox/new/"><strong> DOWNLOAD AND USE ANOTHER BROWSER</strong></center>';
		exit;}


?><!DOCTYPE html>
<html dir="ltr" lang="en-US"><head><!-- Mr Ernest Muroiwa Head developer on the mcs project 0774002797 -->
    <meta charset="utf-8">
    <title>e-Schools Software Solution</title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
<link href="images/logo.png" rel="icon" type="image">
    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="style.css" media="screen">
    <!--[if lte IE 7]><link rel="stylesheet" href="style.ie7.css" media="screen" /><![endif]-->
    <link rel="stylesheet" href="style.responsive.css" media="all">
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lobster|Cabin&amp;subset=latin">
<noscript><meta http-equiv="refresh" content="1;url=error.html"></noscript>
    <script src="jquery.js"></script>
    <script src="script.js"></script>
    <script src="script.responsive.js"></script>



<style>.art-content .art-postcontent-0 .layout-item-0 { border-bottom-style:solid;border-bottom-width:1px;border-bottom-color:#9DC4D7; padding-right: 10px;padding-left: 10px;  }
.art-content .art-postcontent-0 .layout-item-1 { border-right-style:solid;border-right-width:1px;border-right-color:#9DC4D7; padding-right: 10px;padding-left: 10px;  }
.ie7 .art-post .art-layout-cell {border:none !important; padding:0 !important; }
.ie6 .art-post .art-layout-cell {border:none !important; padding:0 !important; }

</style></head>
<body>
<div id="art-main">
<header class="art-header clearfix">


    <div class="art-shapes">
<h1 class="art-headline" data-left="15.78%">
    <a href="http://mcs.ac.zw">Midlands Christian School</a>
</h1>
<h2 class="art-slogan" data-left="99.13%">e-Schools Software Solution</h2>



            </div>

                
                    
</header>
<nav class="art-nav clearfix">
    <ul class="art-hmenu"><li><a href="http://mcs.ac.zw" class="active">Home</a></li></ul> 
    </nav>
<div class="art-sheet clearfix">
            <div class="art-layout-wrapper clearfix">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-sidebar1 clearfix"><div class="art-block clearfix">
        <div class="art-blockheader">
            <h3 class="t">Staff Portal</h3>
        </div>
        <div class="art-blockcontent"><form action="login.php" method="post" name="login" id="form-login">
<fieldset class="input" style="border: 0 none;">
<p id="form-login-username">
 <label for="modlgn_username">Username</label>
<br>
 <input name="username" type="text" class="smalltxt" id="username">
</p>
<p id="form-login-password">
 <label for="modlgn_passwd">Password</label>
<br>
 <input name="password" type="password" class="smalltxt" id="password">
</p>
 
<center><input type="submit" value="Login" name="Submit" class="art-button" style="zoom: 1;"> 
<br><?php 
		
		 function base($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

		
		$a=base('forgot.php');$b=base('open.php');$c=base('forgot2.php');
		$page=sha1('page');
		?>
<a href="index.php?<?php echo $page;?>=<?php echo $a;?>">Forgot your password?</a></center>
</fieldset>
 
 
 
 
 
 
</form></div>
</div><br>
<br>
<div class="art-block clearfix">
        <div class="art-blockheader">
            <h3 class="t">Guardian Portal</h3>
        </div>
        <div class="art-blockcontent"><form action="slogin.php" method="post" name="login" id="form-login">
<fieldset class="input" style="border: 0 none;">
<p id="form-login-username">
 <label for="modlgn_username">Student Number</label><br>
 <input name="regnum" type="text" class="smalltxt" id="regnum" value="">
</p>
<p id="form-login-password">
 <label for="modlgn_passwd">Password</label>
<br>
 <input name="password" type="password" class="smalltxt" id="password">
</p>
 
<center><input type="submit" value="Login" name="Submit" class="art-button" style="zoom: 1;"> 
<br>
<a href="index.php?<?php echo $page;?>=<?php echo $b;?>">Create student account</a><br>
<a href="index.php?<?php echo $page;?>=<?php echo $c;?>">Forgot your password?</a></center>
</fieldset>
 
 
 
 
 
 
</form></div>
</div></div>
                        <div class="art-layout-cell art-content clearfix"><article class="art-post art-article">
                                
                                <div class="art-postcontent art-postcontent-0 clearfix">
                                
                                <?php
function base64($data) {
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
} 

$pg = @$_REQUEST['767013ce0ee0f6d7a07587912eba3104cfaabc15'];
 $pgg=base64($pg);
if($pg != "" && file_exists(dirname(__FILE__)."/".$pgg)){
require(dirname(__FILE__)."/".$pgg);
}elseif(!file_exists(dirname(__FILE__)."/".$pgg))
include_once(dirname(__FILE__)."/404.php");
else{
include_once("home4.php");
}
?>   
                                
                                
                                
</div>


</article></div>
                    </div>
                </div>
            </div><footer class="art-footer clearfix">
<p><span style="text-shadow: rgb(23, 23, 23) 0px 0px 12px;">e-Schools Software Solution</span></p>
<p>Powered By&nbsp;<a href="https://www.facebook.com/divinedevelopers4" target="_blank" title="Muroiwa naChibanda">Divine Developers</a></p>
</footer>

   


</body></html>