<?php

require_once 'lib/mysql.php';
include 'header.html.php';


$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}
?>
<div class="jumbotron">
  <div class="container">
      <img src="/images/header-logo.svg" style="max-width: 450px;width: 60%;" />
  </div>
</div>

<div id="content" class="container">
<h1>Page not found</h1>
<p>If you entered a web address please check it was correct.</p>

<p>You can also browse from the <a href="/">homepage</a> to find the information you need.</p>
</div>
<?php
dbclose();
include("footer.html.php");

?>

