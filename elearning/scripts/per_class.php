<center><?php

 $rs1=mysql_query("SELECT
Count(average.average) AS tot
FROM
average
WHERE
average.average <= 50 AND
average.class = '$_GET[class]' AND
average.grade = '$_GET[level]' AND
average.`session` = '$_SESSION[year]' AND
average.term = '$_SESSION[year]'
") or die(mysql_error());
while($row1 = mysql_fetch_array($rs1)){$a=$row1['tot'];}

 $rs=mysql_query("SELECT
Min(average.average) AS minn,
Count(average.average) AS tot,
Max(average.average) AS maxx
FROM
average
WHERE
average.average >= 50 AND
average.class = '$_GET[class]' AND
average.grade = '$_GET[level]' AND
average.`session` = '$_SESSION[year]' AND
average.term = '$_SESSION[year]'") or die(mysql_error());		  
while($row = mysql_fetch_array($rs)){
	$diff=$row['tot']-$a;
	echo $row['tot']; exit;
	$percent=round(($diff/$row['tot'])/100,2);
print "Class$_GET[level] $_GET[class] acrchived a pass rate of <strong>$percent%</strong><br>
With the highest mark being $row[maxx]<br>
And the lowest mark being $row[minn]";
		}

?></table>