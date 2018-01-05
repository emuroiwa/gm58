<form action="" method="post" name="form1" id="form1">
  <table width="70%" border="0" align="center">
    <tr>
      <td colspan="2"><div align="center">
        <p><u><span class="style1">Add Hostel Allocation Listing</span></u></p>
        <p><span class="style2">Select Hostel name</span></p>
      </div></td>
    </tr>
    <tr>
      <td width="49%"><span class="style2">Hostel Name</span></td>
      <td width="51%"> <?php 
	    $session = date('Y');
include 'opendb.php';
 
$sql="select * from term where term not in(select hostelid from current_allocation)";
$rez=mysql_query($sql);
echo "<select name='hostelid' id='hostelid'>";
?>
<option value="0">--- <span class="style2">Select Hostel </span>---</option>
<?php
while($row=mysql_fetch_array($rez,MYSQL_ASSOC)){

 echo "<option value='$row[id]'>{$row['hostel_name']}</option>"; 
}

?></td>
    </tr>

    <tr>
      <td colspan="2" align="center"><input class="form_submit_button" name="Submit" type="submit" value="Save"></td>
    </tr>
  </table>
</form>