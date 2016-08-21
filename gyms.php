<?php

include("header.html");
include 'lib/mysql.php';

print <<<EOF
<h1>PVA Gyms / Playing Locations</h1>

EOF;

$sql=<<<EOF
SELECT * FROM gyms ORDER BY name
EOF;

if(isset($_GET["gym"])) {
  $gym=preg_replace('/[^\d]/','',$_GET['gym']);
  if(is_numeric($gym)) {
    print "<p>To view a list of all gyms, <a href=\"/gyms.php\">click here</a>.</p>";
    $sql=<<<EOF
SELECT * FROM gyms WHERE id=$gym
EOF;
  }
}

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  if($row_cnt==0) {
    print "<div style=\"\"width: 750px; font-weight: bold; text-align: center;\"\">Nothing to display.</div>";
  }else{

    print <<<EOF
<table class="interiorTable" cellspacing="0">
<tr>
  <th width="20%">Facility</th>
  <th width="80%">Directions</th>
</tr>

EOF;

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $name=$row['name'];
      $address=$row['address'];
      $directions=$row['directions'];
      if(empty($directions)) {
        $directions="&nbsp;";
      }

      $url="";
      if($row['map']!=NULL) {
  $map=$row['map'];
        $url=<<<EOF
<a href="$map">map</a>
EOF;
      }

      print <<<EOF
<tr>
  <td nowrap valign="top"><b>$name</b><br />$address<br />$url</td>
</td>
  <td valign="top">$directions</td>
</tr>
EOF;

    }

  }

  print "</table\n";

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

dbclose();

include("footer.html");

?>
