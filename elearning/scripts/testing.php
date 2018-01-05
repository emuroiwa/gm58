 <?php $conn=odbc_connect('root','mcs','');
$sql="SELECT * FROM customers";
$rs=odbc_exec($conn,$sql); ?>