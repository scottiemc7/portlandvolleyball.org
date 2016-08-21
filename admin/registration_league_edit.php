<?php

include 'header.html';
include '../lib/mysql.php';

echo <<<'EOF'
<h1>Edit article</h1>
EOF;

$error = dbinit();
if ($error !== '') {
    echo "***ERROR*** dbinit: $error\n";
    exit;
}

$id = preg_replace('/[^\d]/', '', $_POST['id']);
$name = preg_replace('/[^a-zA-Z0-9\ \']/', '', $_POST['name']);
$night = preg_replace('/[^a-zA-Z]/', '', $_POST['night']);
$active = preg_replace('/[^01]/', '', $_POST['active']);

if (($name != '') && ($night != '')) {
    $name = dbescape($name);
    if (!dbquery("UPDATE registration_leagues SET name='$name', night='$night', active=$active WHERE id=$id")) {
        $error = dberror();
        echo "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
    } else {
        echo 'This registration league has been successfully edited. <a href="registration_league_add.php">return to list</a>';
    }
}

$sql = <<<EOF
SELECT * FROM registration_leagues WHERE id=$id
EOF;

if ($result = dbquery($sql)) {
    $row_cnt = mysqli_num_rows($result);
    if ($row_cnt == 0) {
        echo '<div style="width: 750px; font-weight: bold; text-align: center;">There are no events to display.</div>';
    } else {
        if ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $name = htmlentities($row['name']);
            $night = htmlentities($row['night']);
            $active = $row['active'];

            $selectedyes = '';
            $selectedno = 'selected="selected"';
            if ($active == 1) {
                $selectedyes = 'selected="selected"';
                $selectedno = '';
            }

            echo <<<EOF
<form name="editEvent" class="eventForm" method="post">
<table>
  <tr>
    <td>Registration League Name</td>
    <td><input type="text" name="name" value="$name" /></td>
    <td>Registration League Night</td>
    <td><input type="text" name="night" value="$night" /></td>
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

<form action="registration_league_add.php" name="delete" style="margin-left: 70px;" method="post">
<p><b>Important:</b> Before deleting a registration league, please make sure no teams are assigned to that registration league.  Otherwise, this could cause some things to look pretty funky.</p>
<input type="hidden" name="delete" value="yes" />
<input type="hidden" name="id" value="$id" />
<input type="submit" value="Delete this registration league" onclick="javascript:return confirm('Really delete this registration league?')">
</form>
EOF;
        }
    }

    mysqli_free_result($result);
} else {
    $error = dberror();
    echo "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
}

dbclose();

echo <<<'EOF'
</body>
</html>
EOF;
