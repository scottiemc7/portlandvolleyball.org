<?php

include 'header.html';
include '../lib/mysql.php';

echo <<<'EOF'
<h1>Edit gym</h1>
EOF;

$error = dbinit();
if ($error !== '') {
    echo "***ERROR*** dbinit: $error\n";
    exit;
}

$id = preg_replace('/[^\d]/', '', $_POST['id']);

if ($_POST['name'] != '') {
    $name = dbescape($_POST['name']);
    $address = dbescape($_POST['address']);
    $map = dbescape($_POST['map']);
    $directions = dbescape($_POST['directions']);

    if (!dbquery("UPDATE gyms SET name='$name', address='$address', map='$map', directions='$directions' WHERE id=$id")) {
        $error = dberror();
        echo "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
    }
    echo 'This gym has been successfully edited. <a href="gyms_add.php">return to list</a>';
}

$sql = <<<EOF
SELECT * FROM gyms WHERE id=$id
EOF;

if ($result = dbquery($sql)) {
    $row_cnt = mysqli_num_rows($result);
    if ($row_cnt == 0) {
        echo '<div style="width: 750px; font-weight: bold; text-align: center;">Gym successfully deleted.</div>';
    } else {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
        $name = htmlentities($row['name']);
        $address = htmlentities($row['address']);
        $map = htmlentities($row['map']);
        $directions = $row['directions'];

        echo <<<EOF
<form name="editGym" class="gymForm" method="post">
<table>
  <tr>
    <td>Gym Name</td>
    <td><input type="text" name="name" value="$name" size="40" /></td>
  </tr>
  <tr>
    <td>Address</td>
    <td><input type="text" name="address" value="$address" size="40" /></td>
  </tr>
  <tr>
    <td>Mapquest link</td>
    <td><input type="text" name="map" value="$map" size="40" /></td>
  </tr>
  <tr>
    <td>Directions</td>
    <td><textarea name="directions" cols="35" rows="3">$directions</textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Edit" /></td>
  </tr>
</table>
<input type="hidden" name="id" value="$id" />
</form>

<form action="gyms_add.php" name="delete" style="margin-left: 70px;" method="post">

<p><b>Important:</b> Before deleting a gym, please make sure there are no games in the database scheduled at that gym.  Otherwise, things are going to look pretty screwy on the schedules page.</p>

<input type="hidden" name="delete" value="yes" />
<input type="hidden" name="id" value="$id" />
<input type="submit" value="Delete this gym" onclick="javascript:return confirm('Really delete this gym?')" />
</form>
EOF;
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
