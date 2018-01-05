<?php

error_reporting(E_ALL ^ E_NOTICE);
require_once 'reader.php';
$data = new Spreadsheet_Excel_Reader("testdata.xls");

?>
<html>
<head>
</head>
<body>
<form method="POST">
<?php
if(isset($_REQUEST["sheet"]))
{
    $sheet = $_REQUEST["sheet"];
    $db = mysql_connect("localhost", "root", "password") 
        or die("error in mysql_connect");
    mysql_select_db('excel', $db) or die("error in mysql_select_db");

    $rowcount = $data->rowcount($sheet);
    
    for($i = 2; $i < $rowcount; ++$i) //rows are 1 based, first row is header
    {
        $query = "INSERT INTO table1 (`value1`, `value2`, `value3`) 
            VALUES (".$data->val($i, 1, $sheet).", 
                '".$data->val($i, 2, $sheet)."', 
                '".$data->val($i, 3, $sheet)."')";
        mysql_query($query, $db) or die("error in mysql_query");
    }
    mysql_close($db);
}
else
{
    ?>
        <select name="sheet">
    <?PHP
    
        foreach($data->boundsheets as $key => $row)
        {
            ?>
                <option value="<?PHP echo $key; ?>">
                    <?PHP echo $row["name"]; ?></option>
            <?PHP
        }
    ?>
        </select>
        <input type="submit" value="import" />
    <?PHP
}
?>
</form>
</body>
</html>