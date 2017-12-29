<?php
mysql_connect('localhost','root','');
mysql_select_db('rvr');


	$rs=mysql_query("SELECT 'Woodlands 2' location,`STAND NO_` number,`SIZE`,REPLACE(REPLACE (`TOTAL COST`, ',', ''),'.','') / 100 price,REPLACE(REPLACE(`joining`, ',', ''),'.','')/100 deposit,REPLACE(REPLACE(`TOTAL PAID`, ',', ''),'.','')/100 balance,`Jan.2012` instal ,`DATE PURCHASED`,`office`,`SURNAME` surname ,`NAME` name,`CELL NO_` cell,`ID.NO` idno,`FILE` file from  `woodland two`  ");

$xxxx=1;
                                      //echo str_replace('0773 245 337','',' ');

										while($row=mysql_fetch_array($rs))
										{
											
											$old_date =$row['DATE PURCHASED'];
												$old_date_timestamp = strtotime($old_date);
$new_date = date('Y-m-d H:i:s', $old_date_timestamp); 
											if($new_date=="1970-01-01 00:00:00"){
												$new_date="2011-10-01 00:00:00";
											}
											
											if(!is_numeric($row['SIZE'])){
												$size=300;
											}else{
												$size=$row['SIZE'];
											}
											//echo $new_date."<br>";
											
											
										
//											echo "INSERT INTO `stand` (
//	`location`,
//	`number`,
//	`area`,
//	`price`,
//	`deposit`,
//	`instalments`
//)
//VALUES(	'$row[location]','$row[number]'),'$row[SIZE]','$row[price]','$row[deposit]','$row[instal]';";
//											echo "INSERT INTO `clients` (`name`, `surname`, `address`, `email`, `contact`, `idnum`, `stand_id`, `sex`, `dob`, `office`, `file_number`, `date`, `id`) VALUES ('$row[name]', '$row[surname]', '', '', '$row[cell]','$row[idno]', '1', '', '', '$row[office]', '$row[file]', '$new_date', '$xxxx')"."<br>";
//											
									mysql_query("INSERT INTO `stand` (
	`location`,
	`number`,
	`area`,
	`price`,
	`deposit`,
	`instalments`,`datestatus`,`date`
)
VALUES(	'$row[location]','$row[number]','$size','$row[price]','$row[deposit]','$row[instal]','$new_date','$new_date')" )or die(mysql_error());
                                     

		mysql_query("INSERT INTO `payment` (`cash`, `stand`, `date`, `capturer`, `payment_type`, `d`, `payment_date`, `value_date`, `description`) VALUES ('$row[balance]', '$xxxx', '2017-03-05 07:36:16', 'Data Takeom', 'Credit', 'Data Takeon', '2017-03-05 07:36:16', '2017-03-05 07:36:16', 'Data Takeon')") or die(mysql_error());
											
		mysql_query("INSERT INTO `clients` (`name`, `surname`, `address`, `email`, `contact`, `idnum`, `stand_id`, `sex`, `dob`, `office`, `file_number`, `date`) VALUES ('$row[name]', '$row[surname]', '', '', '$row[cell]','$row[idno]', '$xxxx', '', '', '$row[office]', '$row[file]', '$new_date')") or die(mysql_error());
											
		mysql_query("INSERT INTO `owners` (`client_id`, `owners_date`, `stand_id`) VALUES ('$xxxx', NOW(), '$xxxx')") or die(mysql_error());
											$xxxx++;
										}
echo "done";
										?>
    