<?php
	session_start();

	if (!isset($_POST['uname'])){
		$_SESSION['logged_in'] = false;
	} else {
		require_once '../lib/mysql.php';

		$error=dbinit();
		if($error!=="") {
		  print "***ERROR*** dbinit: $error\n";
		  exit;
		}

		$username = $_POST['uname'];
		$password = $_POST['pw'];
		$hash = md5($password);

		$sql = "SELECT * from admins WHERE username LIKE '{$username}' AND password LIKE '{$hash}' LIMIT 1";

		if(! $result=dbquery($sql)) {
		  $error=dberror();
		  print "***ERROR*** dbquery: Failed query<br />$error\n";
		  exit;
		}
		if (mysqli_num_rows($result)==0) {
			$_SESSION['logged_in'] = false;
			header("Location: login.php?failed=1");
		} else {
			$_SESSION['logged_in'] = true;
			header("Location: index.php");
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<link rel="stylesheet" type="text/css" href="/admin/admin.css">
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-82904877-1', 'auto');
	  ga('send', 'pageview');

	</script>
</head>
<body>

	<form action="login.php" method="post" class="eventForm" cellpadding="6">
		<?php
		parse_str($_SERVER['QUERY_STRING']);
		if ($incorrect_login == true) {?>
			<p>Your login was incorrect. Please try again.</p>
			<hr />
		<?php } ?>
	<table>
		<tr>
			<td>Login:</td>
			<td><input autofocus type="text" name="uname"></td>
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
