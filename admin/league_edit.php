<?php

include 'header.html';
include '/home/pva/portlandvolleyball.org/lib/mysql.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

print <<<EOF
<h1>Edit league</h1>
EOF;

$id=preg_replace('/[^\d]/','',$_POST['id']);
$name=preg_replace('/[^a-zA-Z0-9\ \-\']/','',$_POST['name']);
$active=preg_replace('/[^\d]/','',$_POST['active']);
if(!empty($name) && !empty($id) && ($active==1 || $active==0)) {
  $name=dbescape($name);
  if(!dbquery("UPDATE leagues SET name='$name', active=$active WHERE id=$id")) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
  print "This league has been successfully edited. <a href=\"league_add.php\">return to list</a>";
}

$sql=<<<EOF
SELECT * FROM leagues WHERE id=$id
EOF;

if($result=dbquery($sql)) {

  if($row=mysqli_fetch_assoc($result)) {
    $id=$row['id'];
    $name=htmlentities($row['name']);
    $active=$row['active'];

    $selectedyes='selected="selected"';
    $selectedno='';
    if($active!=1) {
      $selectedyes='';
      $selectedno='selected="selected"';
    }

    print <<<EOF
<form name="editEvent" class="eventForm" method="post">
<table>
  <tr>
    <td>League Name</td>
    <td><input type="text" name="name" value="$name" /></td>
  </tr>
  <tr>
    <td>Active</td>
    <td>
      <select name="active">
        <option value="1" $selectedyes>Yes</option>
        <option value="0" $selectedno>No</option>
      </select>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Edit"></td>
  </tr>
</table>			
<input type="hidden" name="id" value="$id" />
</form>

<form action="league_add.php" name="delete" style="margin-left: 70px;" method="post">
<p><b>Important:</b> Before deleting a league, please make sure no teams are assigned to that league.  Otherwise, this could cause some things to look pretty funky.</p>
<input type="hidden" name="delete" value="yes">
<input type="hidden" name="id" value="$id" />
<input type="submit" value="Delete this league" onclick="javascript:return confirm('Really delete this league?')">
</form>
EOF;

  }else{
    print "<div style=\"width: 750px; font-weight: bold; text-align: center;\">There is no league to display.</div>";
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
