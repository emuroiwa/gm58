<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body><center>
<?php include 'mathsresult.php';
 //include 'englishresult.php'; ?>
<table width="100%" border="1" background="white">
  <tr>
    <td width="12%">Subject</td>
    
    <td width="9%">Mark attained</td>
    <td width="7%">Effort</td>
    <td width="9%">Class average</td>
    <td width="11%">Stream Average</td>
    <td width="42%">Remarks</td>
  </tr>
  
   <tr>
    <td><strong>Maths</strong></td>
    <td><?php echo $overall; ?></td>
    <td>--</td>
    <td><?php echo $mathsavg; ?></td>
    <td><?php echo $mathsavg1; ?></td>
    <td><?php echo $remarks; ?></td>
  </tr>
  <tr>
    <td>Mechanical</td>
    <td><?php echo $mecmark; ?></td>
    <td><?php echo $meceff ?></td>
    <td><?php echo $mec; ?></td>
    <td><?php echo $smec; ?></td>
    
  </tr><tr>
    <td>Mental</td>
    <td><?php echo $menmark; ?></td>
    <td><?php echo $meneff ?></td>
    <td><?php echo $men; ?></td>
    <td><?php echo $smen; ?></td>
    
  </tr><tr>
    <td>Problems</td>
    <td><?php echo $probmark; ?></td>
    <td><?php echo $probeff ?></td>
    <td><?php echo $prob; ?></td>
    <td><?php echo $sprob; ?></td>
    
  </tr>
  
  
  <tr>
    <td><strong>English</strong></td>
    <td><?php echo $overall2; ?></td>
    <td>--</td>
    <td><?php echo $englishavg; ?></td>
    <td><?php echo $englishavg1; ?></td>
    <td><?php echo $remarks2; ?></td>
  </tr>
  <tr>
    <td>Spelling</td>
    <td><?php echo $spmark; ?></td>
    <td><?php echo $speff ?></td>
    <td><?php echo $sp; ?></td>
    <td><?php echo $ssp; ?></td>
    
  </tr><tr>
    <td>Mental</td>
    <td><?php echo $menmark; ?></td>
    <td><?php echo $meneff ?></td>
    <td><?php echo $men; ?></td>
    <td><?php echo $smen; ?></td>
    
  </tr><tr>
    <td>Problems</td>
    <td><?php echo $probmark; ?></td>
    <td><?php echo $probeff ?></td>
    <td><?php echo $prob; ?></td>
    <td><?php echo $sprob; ?></td>
    
  </tr>
  
  
</table></center>

</body>
</html>