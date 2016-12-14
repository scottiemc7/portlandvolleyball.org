<?php
	session_start();
	$user = $_REQUEST['uname'];
	$pass = $_REQUEST['pw'];
	if ($user == "pva_admin" && $pass == "deep energy idea store") {
		$_SESSION['logged_in'] = true;
		header("Location: index.php");
	} else {
		$_SESSION['logged_in'] = false;
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<link rel="stylesheet" type="text/css" href="/admin/admin.css">
	<script language="javascript">
		function loadMe() {
			document.forms[0].uname.focus();
		}
	</script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-82904877-1', 'auto');
	  ga('send', 'pageview');

	</script>
</head>
<body onLoad="javascript:loadMe();">
	<form action="login.php" method="get" class="eventForm" cellpadding="6">
	<table>
		<tr>
			<td>Login:</td>
			<td><input type="text" name="uname"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="pw"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" value="submit"></td>
		</tr>
	</table>
	</form>
</body>
</html>
