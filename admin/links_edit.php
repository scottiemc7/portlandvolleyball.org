<?php

require_once '../lib/mysql.php';
include 'header.html.php';

print <<<EOF
<h1>Edit article</h1>
EOF;

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

$id=preg_replace('/[^\d]/','',$_POST['id']);

if($_POST['linktext'] != "") {
  $link=dbescape($_POST['link']);
  $linktext=dbescape($_POST['linktext']);
  $description=dbescape($_POST['description']);

  if(!dbquery("UPDATE linkage SET link='$link', linktext='$linktext', description='$description' WHERE id=$id")) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
  print "This link has been successfully edited.  <a href=\"links_add.php\">return to list</a>";
}

$sql=<<<EOF
SELECT * FROM linkage WHERE id=$id
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  if($row_cnt==0) {
    print "<div style=\"width: 750px; font-weight: bold; text-align: center;\">There are no links to display.</div>";
  }else{

    print <<<EOF
<form name="editEvent" class="eventForm" method="post">
<table>
EOF;

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $link=htmlentities($row['link']);
      $linktext=htmlentities($row['linktext']);
      $description=htmlentities($row['description']);

      print <<<EOF
  <tr>
    <td>URL:</td>
    <td><input type="text" name="link" value="$link" size="40" /></td>
  </tr>
  <tr>
    <td>Text:</td>
    <td><input type="text" name="linktext" value="$linktext" size="40" />
  </tr>
  <tr>
    <td>Description:</td>
    <td><textarea name="description" cols="35" rows="5">$description</textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Edit" /></td>
  </tr>
</table>			
<input type="hidden" name="id" value="$id" />
</form>
<form action="links_add.php" name="delete" method="post" style="margin-left: 70px;">
  <input type="hidden" name="delete" value="yes" />
  <input type="hidden" name="id" value="$id" />
  <input type="submit" value="Delete this link" onclick="javascript:return confirm('Really delete this link?')">
</form>
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
