<?php
	session_start();
	//session_register('logged_in_ref');
	if (!$_SESSION['logged_in_ref']) {
   		header("Location: /ref/login.php");
   	}
?>
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">

<html>
<head>
	<style type="text/css" media="all">
 	  @import "ref.css";
	</style>

	<link rel="stylesheet"
   	type="text/css"
   	media="print" href="print.css" />
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
<div class="header">PVA Administration</div>
<span class="button"><a href="/index.php">PVA site</a></span>
<span class="button"><a href="index.php">Edit scores</a></span>
<span class="button"><a href="login.php">Ref login/out</a></span>
