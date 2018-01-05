<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body><script type="text/javascript">
//<![CDATA[
window.onload = function()
{
	s = document.getElementsByTagName("SPAN");
	for (i = 0; i < s.length; i++)
	{
		if (s[i].className == 'plus')
		{
			s[i].onclick = function()
			{
				x = (this.parentNode).childNodes[1];
				if (x.expanded)
				{
					x.style.display = 'none';
					this.innerHTML = 'Click here to read the candidate\'s blurb';
					x.expanded = false;
				}
				else
				{
					x.style.display = 'block';
					this.innerHTML = 'Click here to close the candidate\'s blurb';
					x.expanded = true;
				}
			}
		}
	}
}
//]]>
</script>
<style>

span.plus {
	cursor: pointer;
	text-decoration: underline;
}

div.blurbdis {
	display: none;
}</style>

<?php

echo "<span class=plus>Click here to read the candidate's blurb</span><div class=blurbdis><span>jkkchjzhcxxhczx</span></div>";
?>
</body>
</html>