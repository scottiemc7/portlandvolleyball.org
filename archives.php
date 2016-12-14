<?php

include("header.html");
include 'lib/mysql.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}
?>

<div id="content" class="container">
<h1>News Archives</h1>
  <div class="row">

<div class="col-md-12">
<?php

$sql=<<<EOF
SELECT title, article, dtm FROM home_page WHERE 1 and storycolumn=1 ORDER BY priority desc, dtm DESC LIMIT 5, 99999
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  // print "Number of rows: $row_cnt<p />\n";

  while($row=mysqli_fetch_assoc($result)) {
    $title=$row['title'];
    $article=preg_replace('/\\\"/','"',$row['article']);
    $posted_on = date("F j, Y, g:i a", strtotime($row['dtm']));
    print <<<EOF
<article>
<h2>$title</h2>
<p><strong>$posted_on</strong></p>
<p>$article</p>
</article>
EOF;
  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

?>
</div>
</div>
<?php
dbclose();
include("footer.html");

?>

