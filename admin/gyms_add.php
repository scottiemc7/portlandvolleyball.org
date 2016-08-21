<?php

include 'header.html';
include '../lib/mysql.php';

$error = dbinit();
if ($error !== '') {
    echo "***ERROR*** dbinit: $error\n";
    exit;
}

if ($_POST['delete'] == 'yes') {
    $id = preg_replace('/[^\d]/', '', $_POST['id']);
    if (!dbquery("DELETE FROM gyms WHERE id=$id")) {
        $error = dberror();
        echo "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
    }
}

if ($_POST['name'] != '') {
    $name = dbescape($_POST['name']);
    $address = dbescape($_POST['address']);
    $map = dbescape($_POST['map']);
    $directions = dbescape($_POST['directions']);

    if (!dbquery("INSERT INTO gyms (name, address, map, directions) VALUES('$name', '$address', '$map', '$directions')")) {
        $error = dberror();
        echo "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
    }
}

echo <<<'EOF'
<h1>Add new gym</h1>

<form name="addEvent" class="eventForm" method="post">
<table>
  <tr>
    <td>Gym Name</td>
    <td><input type="text" name="name" size="40"></td>
  </tr>
  <tr>
    <td>Address</td>
    <td><input type="text" name="address" size="40"></td>
  </tr>
  <tr>
    <td>Mapquest link</td>
    <td><input type="text" name="map" size="40"></td>
  </tr>
  <tr>
    <td>Directions</td>
    <td><textarea name="directions" cols="35" rows="3"></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Add Gym"></td>
  </tr>
</table>
</form>
EOF;

$sql = <<<'EOF'
SELECT * FROM gyms ORDER BY name
EOF;

if ($result = dbquery($sql)) {
    $row_cnt = mysqli_num_rows($result);
    if ($row_cnt == 0) {
        echo '<div style="width: 750px; font-weight: bold; text-align: center;">There are no items to display.</div>';
    } else {
        echo <<<'EOF'
<h1>Current gyms</h1>
<table cellpadding="6" cellspacing="0" width="750" class="eventTable">
  <tr>
    <th>Name</th>
    <th>Address</th>
    <th>Map?</th>
    <th>Directions</th>
    <th>&nbsp;</th>
  </tr>
EOF;

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $name = $row['name'];
            $address = $row['address'];
            $map = htmlentities($row['map']);
            $directions = $row['directions'];

            if (empty($address)) {
                $address = '&nbsp;';
            }

            if (empty($map)) {
                $map = 'no';
            } else {
                $map = "<a href=\"$map\">yes</a>";
            }

            if (empty($directions)) {
                $directions = '&nbsp;';
            }

            echo <<<EOF
  <tr>
    <td valign="top">$name</td>
    <td valign="top">$address</td>
    <td valign="top">$map</td>
    <td valign="top">$directions</td>
    <td>
      <form action="gyms_edit.php" method="post">
        <input type="submit" value="Edit" />
        <input type="hidden" name="id" value="$id" />
      </form>
    </td>
  </tr>
EOF;
        }
        echo '</table>';
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
