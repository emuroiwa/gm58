<?php
$date = 12/25/2013;
$date2=12/22/2013;
$start = strtotime("12/25/2013");
$end = strtotime("12/23/2013");

$days_between = ceil(abs($end - $start) / 86400);
echo $days_between;
 ?>