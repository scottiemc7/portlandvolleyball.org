<?php

require_once '../lib/mysql.php';
include 'header.html.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

if($_POST['delete'] == "yes") {
  $id=preg_replace('/[^\d]/','',$_POST['id']);
  if(!empty($id)) {
    if(!dbquery("DELETE FROM linkage WHERE id=$id")) {
      $error=dberror();
      print "***ERROR*** dbquery: Failed query<br />$error\n";
      exit;
    }
  }
}

if($_POST['link'] != "") {
  $link=dbescape($_POST['link']);
  $linktext=dbescape($_POST['linktext']);
  $description=dbescape($_POST['description']);

  $sql="INSERT INTO linkage (link, linktext, description) VALUES ('$link', '$linktext', '$description')";
  if(!dbquery($sql)) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}

print <<<EOF
<h1>Add Link</h1>
<b>All fields are required.</b>
<form name="addLink" class="eventForm" method="post">
<table>
  <tr>
    <td>URL:</td>
    <td><input type="text" name="link" size="40" /></td>
  </tr>
  <tr>
    <td>Text:</td>
    <td><input type="text" name="linktext" size="40" />
  </tr>
  <tr>
    <td>Description:</td>
    <td><textarea name="description" cols="35" rows="5"></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Add Link" /></td>
  </tr>
</table>
</form>

<h1>Current Links</h1>
EOF;

$sql=<<<EOF
SELECT * FROM linkage ORDER BY id DESC
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  if($row_cnt==0) {
    print "<div style=\"width: 750px; font-weight: bold; text-align: center;\">There are no items to display.</div>";
  }else{

    print <<<EOF
<table cellpadding="6" cellspacing="0" width="750" class="eventTable">
  <tr>
    <th>URL</th>
    <th>Link Text</th>
    <th>Description</th>
    <th>&nbsp;</th>
  </tr>
EOF;

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $link=$row['link'];
      $linktext=$row['linktext'];
      $description=$row['description'];

      print <<<EOF
  <tr>
    <td valign="top">$link</td>
    <td valign="top">$linktext</td>
    <td valign="top">$description</td>
    <td>
      <form action="links_edit.php" method="post">
        <input type="submit" value="Edit" />
        <input type="hidden" name="id" value="$id" />
      </form>
    </td>
  </tr>
EOF;
    }

    print "</table>";

  }
  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

dbclose();

print <<<EOF
</body>
</html>
EOF;

?>
