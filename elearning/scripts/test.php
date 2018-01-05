<script language="javascript">
function programmeOnChange(faculty) {
	$.ajax({
	  url: "scripts/ajax.get.department.php?faculty="+faculty,
	  dataType: "json",
	  
	  success: function(data) {
		var options, index, select, option;
		
		//alert(data);
		// Get the raw DOM object for the select box
		select = parent.document.getElementById('programme');
	
		// Clear the old options
		select.options.length = 0;
	
		// Load the new options
		options = data.options; // Or whatever source information you're working with
		for (index = 0; index < options.length; ++index) {
		  option = options[index];
		  newOption = new Option(option.text, option.value);
		  newOption.selected = true;
		  select.options.add(newOption);
		}
	  }
	});

}

function programmeOnChange2(faculty) {
	$.ajax({
	  url: "scripts/ajax.get.department.php?faculty="+faculty,
	  dataType: "json",
	  
	  success: function(data) {
		var options, index, select, option;
		
		//alert(data);
		// Get the raw DOM object for the select box
		select = parent.document.getElementById('programme2');
	
		// Clear the old options
		select.options.length = 0;
	
		// Load the new options
		options = data.options; // Or whatever source information you're working with
		for (index = 0; index < options.length; ++index) {
		  option = options[index];
		  newOption = new Option(option.text, option.value);
		  newOption.selected = true;
		  select.options.add(newOption);
		}
	  }
	});

}

</script><?php  include 'opendb.php';
$sql=mysql_query("select * from news"); ?><form name = "app_programme" method = "post" id="app_programme"><table width="320" border = "0">
	<tr>
	  <td>Faculty</td>
	  <td><select name="faculty" id="faculty" onchange="programmeOnChange(this.value)">
	  		<option value="0">--- Select Faculty ---</option>	
	  		<?php while($row=mysql_fetch_array($sql,MYSQL_ASSOC)){ ?>
            
				<option value="<?php echo $row['id'];?>"><?php echo $row['news']?></option>
			<?php } ?>
	    </select>
	  </td>
	</tr>
	<tr>
	  <td>Programme</td>
	  <td><select name="programme" id="programme">
	    </select>
	  </td>
	</tr>
	
	<tr><td colspan = "2"></td>
	</table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>