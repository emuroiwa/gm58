
	

<html>
<body onload = "load()">
<script>
function load()
{ 

try
{
var ax = new ActiveXObject("WScript.Network");
alert('User: ' + ax.UserName );
alert('Computer: ' + ax.ComputerName);
}
catch (e)
{
document.write('Permission to access computer name is denied' + '<br />');
} 

</script>
</form>
</body>
</html>

