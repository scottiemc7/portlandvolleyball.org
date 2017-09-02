<?php

include '/home/pva/portlandvolleyball.org/lib/mysql.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

$sql=<<<EOF
SELECT 'Hello world!' AS _message FROM DUAL
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  print "Number of rows: $row_cnt<p />\n";

  while($row=mysqli_fetch_assoc($result)) {
    echo htmlentities($row['_message']);
  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

$str=dbinfo();
print <<<EOF
<pre>$str</pre>
EOF;

dbclose();

?>
