<?php

require_once '../lib/mysql.php';
include 'header.html.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

$nights = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday',
  'Friday', 'Saturday'];

print <<<EOF
<h1>Edit league</h1>
EOF;

$id = preg_replace('/[^\d]/','',$_POST['id']);
$name = preg_replace('/[^a-zA-Z0-9\ \-\']/','',$_POST['name']);
$night = preg_replace('/[^a-zA-Z0-9\ \-\']/','',$_POST['night']);
$cap = preg_replace('/[^\d]/','',$_POST['cap']);
$active = preg_replace('/[^\d]/','',$_POST['active']);

function validNight($night) {
  global $nights;
  return in_array($night, $nights);
}

$fieldsSupplied = !empty($id) &&
                  !empty($name) &&
                  !empty($night) && validNight($night) &&
                  !empty($cap) &&
                  ($active == 1 || $active == 0);

if($fieldsSupplied) {
  $id = (int) $id;
  $name = dbescape($name);
  $night = dbescape($night);
  $cap = (int) $cap;
  if(!dbquery("UPDATE leagues SET name='$name', night = '$night', cap = $cap, active = $active WHERE id = $id")) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
  print "This league has been successfully updated. <a href=\"league_add.php\">return to list</a>";
}

$sql=<<<EOF
SELECT * FROM leagues WHERE id = $id
EOF;

if($result=dbquery($sql)) {

  if($row=mysqli_fetch_assoc($result)) {
    $id=$row['id'];
    $name=htmlentities($row['name']);
    $night = $row['night'];
    $cap = $row['cap'];
    $active=$row['active'];

    $selectedyes='selected="selected"';
    $selectedno='';
    if($active!=1) {
      $selectedyes='';
      $selectedno='selected="selected"';
    }


    function selected($nightOption, $night) {
      if ($nightOption == $night) {
        return 'selected = "selected"';
      }
      return '';
    }

?>
<form name="editLeague" class="eventForm" method="post">
<table>
  <tr>
    <td>League Name</td>
    <td><input type="text" name="name" value="<?php echo $name; ?>" /></td>
  </tr>
  <tr>
    <td>League Night</td>
    <td>
      <select name="night">
      <?php foreach($nights as $nightOption) { ?>
        <option <?php echo selected($nightOption, $night); ?>><?php echo $nightOption; ?></option>
      <?php } ?>
      </select>
    </td>
  </tr>
  <tr>
    <td>Cap</td>
    <td><input type="number" name="cap" value="<?php echo $cap; ?>" /></td>
  </tr>
  <tr>
    <td>Active</td>
    <td>
      <select name="active">
        <option value="1" <?php echo $selectedyes; ?>>Yes</option>
        <option value="0" <?php echo $selectedno; ?>>No</option>
      </select>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Update"></td>
  </tr>
</table>
<input type="hidden" name="id" value="<?php echo $id; ?>" />
</form>

<form action="league_add.php" name="delete" style="margin-left: 70px;" method="post">
<p><b>Important:</b> Before deleting a league, please make sure no teams are assigned to that league.  Otherwise, this could cause some things to look pretty funky.</p>
<input type="hidden" name="delete" value="yes">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="submit" value="Delete this league" onclick="javascript:return confirm('Really delete this league?')">
</form>

<?php

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
