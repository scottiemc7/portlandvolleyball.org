<?php

include("header.html");
include 'lib/mysql.php';

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
<?php

print <<<EOF
<div class="facebook-alert alert alert-info">
<h4>PVA is now on Facebook!</h4>
<p>To find a team or to look for a sub go to: <br /><a href="https://www.facebook.com/groups/portlandvolleyballassociation/" target="_blank">Portland Volleyball Association Managers and Free Agents</a>
<p>For general information go to: <br /><a href="http://www.facebook.com/PortlandVolleyballAssociation" target="_blank">Portland Volleyball Association</a>
EOF;

$sql=<<<EOF
SELECT title, article, dtm FROM home_page WHERE 1 and storycolumn=2 order by priority desc, dtm desc
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);

  while($row=mysqli_fetch_assoc($result)) {
    $title=$row['title'];
    $article=preg_replace('/\\\"/','"',$row['article']);
    print <<<EOF
<h4>$title</h4>
<p>$article</p>
EOF;
  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

print "</div\n";

$sql=<<<EOF
SELECT title, article, dtm FROM home_page WHERE 1 and storycolumn=1 order by priority desc, dtm desc
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  print "Number of rows: $row_cnt<p />\n";

  while($row=mysqli_fetch_assoc($result)) {
    $title=$row['title'];
    $article=preg_replace('/\\\"/','"',$row['article']);
    $posted_on = date("F j, Y, g:i a", strtotime($row['dtm']));
    print <<<EOF
<h2>$title</h2>
<p><strong>$posted_on</strong></p>
<p>$article</p>
EOF;
  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

dbclose();

include("footer.html");

?>

