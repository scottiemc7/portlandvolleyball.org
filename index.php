<?php

include("header.html");
include '/home/pva/portlandvolleyball.org/lib/mysql.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

print <<<EOF
<div id="sidebar">
<h4>PVA is now on Facebook!</h4>
<p>To find a team or to look for a sub go to <a href="https://www.facebook.com/groups/portlandvolleyballassociation/" target="_blank">Portland Volleyball Association Managers and Free Agents</a>
<p>For general information go to <a href="http://www.facebook.com/PortlandVolleyballAssociation" target="_blank">Portland Volleyball Association</a>
EOF;

$sql=<<<EOF
SELECT title, article FROM home_page WHERE 1 and storycolumn=2 order by priority desc, dtm desc
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);

  while($row=mysqli_fetch_assoc($result)) {
    $title=$row['title'];
    $article=ereg_replace('\\\"','"',$row['article']);

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
SELECT title, article FROM home_page WHERE 1 and storycolumn=1 order by priority desc, dtm desc
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  print "Number of rows: $row_cnt<p />\n";

  while($row=mysqli_fetch_assoc($result)) {
    $title=$row['title'];
    $article=ereg_replace('\\\"','"',$row['article']);

    print <<<EOF
<h1>$title</h1>
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

