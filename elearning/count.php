 <html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Limit the number of characters in textbox or textarea</title>
<script type="text/javascript">
function LimtCharacters(txtMsg, CharLength, indicator) {
chars = txtMsg.value.length;
document.getElementById(indicator).innerHTML = CharLength - chars;
if (chars > CharLength) {
txtMsg.value = txtMsg.value.substring(0, CharLength);
}
}
</script>
</head>
<body>
<div style="font-family:Verdana; font-size:13px">
Number of Characters Left:
<label id="lblcount" style="background-color:#E2EEF1;color:Red;font-weight:bold;">140</label><br/>
<textarea id="mytextbox" rows="5" cols="25"  onMouseOver="LimtCharacters(this,140,'lblcount');" maxlength=""></textarea>
</div>
</body>
</html>