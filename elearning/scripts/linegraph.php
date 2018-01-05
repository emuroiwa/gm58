<?php
include ('../student/opendb.php');
include('../student/phpgraphlib.php');


$result = mysql_query("SELECT subject, mark
FROM results
WHERE
results.`session` = '$_GET[year]' AND
results.term = '$_GET[term]' AND

results.reg = '$_GET[reg]' AND
results.`subject_id` = 'social'
group by subject
");



$arr = null;
$x = 0;
while($data = mysql_fetch_assoc($result)){
	$arr[$data['subject']] = $data['mark'];
	$x++;
}

$graph = new PHPGraphLib(700,500);
$graph->addData($arr);
$graph->setTitle('SOCIAL ATTITUDES');
$graph->setBars(true);
$graph->setLine(true);
$graph->setDataPoints(true);
$graph->setDataPointColor('maroon');
$graph->setDataValues(true);
$graph->setDataValueColor('maroon');
$graph->setGoalLine(.0025);
$graph->setGoalLineColor('red');
$graph->createGraph();

?>
