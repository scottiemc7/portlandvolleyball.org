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
    if(!dbquery("DELETE FROM leagues WHERE id=$id")) {
      $error=dberror();
      print "***ERROR*** dbquery: Failed query<br />$error\n";
      exit;
    }
  }
}

$name = preg_replace('/[^a-zA-Z0-9\ \-\']/', '', $_POST['name']);
$night = preg_replace('/[^a-zA-Z0-9\ \-\']/', '', $_POST['night']);
$cap = $_POST['cap'];

if(!empty($name) && !empty($cap) && !empty($night)) {
  $name = dbescape($name);
  $night = dbescape($night);
  if(!dbquery("INSERT INTO leagues(name, night, cap) VALUES('$name', '$night', $cap)")) {
    $error = dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}

print <<<EOF
<h1>Add league</h1>

<form name="addEvent" class="eventForm" method="post">
<table>
  <tr>
    <td>League Name</td>
    <td><input type="text" name="name" value="" size="40" /></td>
  </tr>
  <tr>
    <td>League Night</td>
    <td>
      <select name="night">
        <option>Sunday</option>
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
        <option>Saturday</option>
      </select>
    </td>
  </tr>
  <tr>
    <td>Cap</td>
    <td><input type="number" name="cap" value="8" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Add League" /></td>
  </tr>
</table>
</form>
EOF;

$sql=<<<EOF
SELECT * FROM leagues ORDER BY active DESC, name, night
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  if($row_cnt==0) {
    print "div style=\"width: 750px; font-weight: bold; text-align: center;\">There are no items to display.</div>";
  }else{

    print <<<EOF
<h1>Current leagues</h1>
<table cellpadding="6" cellspacing="0" width="750" class="eventTable">
  <tr>
    <th>League Name</th>
    <th>League Night</th>
    <th>Cap</th>
    <th>Active</th>
    <th>&nbsp;</th>
  </tr>
EOF;

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $name=$row['name'];
      $night = $row['night'];
      $cap = $row['cap'];
      $active=$row['active'];

      if($active==1) {
        $active="Yes";
      }else{
        $active="No";
      }

      print <<<EOF
  <tr>
    <td valign="top">$name</td>
    <td valign="top">$night</td>
    <td valign="top">$cap</td>
    <td valign="top">$active</td>
    <td>
      <form action="league_edit.php" method="post">
        <input type="submit" value="Edit" />
        <input type="hidden" name="id" value="$id" />
      </form>
    </td>
  </tr>
EOF;

    }

  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

dbclose();

print <<<EOF
</table>
</body>
</html>
EOF;

?>
