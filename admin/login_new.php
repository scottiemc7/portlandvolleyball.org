<html>
<head>
	<title>User Login Form - PHP MySQL Ligin System | W3Epic.com</title>
</head>
<body>
<h1>User Login Form - PHP MySQL Ligin System | W3Epic.com</h1>
<?php
if (!isset($_POST['submit'])){
?>
<!-- The HTML login form -->
	<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		Username: <input type="text" name="username" /><br />
		Password: <input type="password" name="password" /><br />

		<input type="submit" name="submit" value="Login" />
	</form>
<?php
} else {
	require_once '../lib/mysql.php';

	$error=dbinit();
	if($error!=="") {
	  print "***ERROR*** dbinit: $error\n";
	  exit;
	}

	$username = $_POST['username'];
	$password = $_POST['password'];
	$hash = md5($password);

	$sql = "SELECT * from admins WHERE username LIKE '{$username}' AND password LIKE '{$hash}' LIMIT 1";
	echo $sql;

if(! $result=dbquery($sql)) {
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

echo mysqli_num_rows($result);

echo 'sadkl';

	if (mysqli_num_rows($result)==0) {
		echo "<p>Invalid username/password combination</p>";
	} else {
		echo "<p>Logged in successfully</p>";
		// do stuffs
	}
}
?>
</body>
</html>