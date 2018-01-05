<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
 mysql_query("DELETE FROM `users` WHERE username= '$_GET[id]'");
 mysql_query("DELETE FROM `class` WHERE teacher= '$_GET[id]'");

 
  ?>
  <script language="javascript">
  alert("Deleted............")
location = 'index.php?page=manage.php'  </script>
  <?php
  

  
?>
</body>
</html>