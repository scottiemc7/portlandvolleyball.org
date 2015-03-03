<?php
	session_start();
	//session_register('logged_in');
	//$user = $HTTP_GET_VARS['uname'];
	//$pass = $HTTP_GET_VARS['pw'];
	$user = $_REQUEST['uname'];
	$pass = $_REQUEST['pw'];
	if ($user == "pva_admin" && $pass == "@dm1n1st37") {
		//$HTTP_SESSION_VARS['logged_in'] = true;
		$_SESSION['logged_in'] = true;
		header("Location: index.php");
	} else {
		//$HTTP_SESSION_VARS['logged_in'] = false;
		$_SESSION['logged_in'] = false;
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<link rel="stylesheet" type="text/css" href="admin.css">
	<script language="javascript">
		function loadMe() {
			document.forms[0].uname.focus();
		}
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
