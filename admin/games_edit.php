<?php

include 'header.html';
include '../lib/mysql.php';
include '../lib/support.php';

echo <<<'EOF'
<h1>Edit Game</h1>
EOF;

$error = dbinit();
if ($error !== '') {
    echo "***ERROR*** dbinit: $error\n";
    exit;
}

$id = null;
if (isset($_POST['id'])) {
    $id = preg_replace('/[^\d]/', '', $_POST['id']);
}
if (!is_numeric($id)) {
    echo "***ERROR*** Invalid ID\n";
    exit;
}

if ($_POST['home'] != '') {
    $dtarray = explode('/', $_POST['date']);
    if (!checkdate($dtarray[0], $dtarray[1], $dtarray[2])) {
        echo <<<'EOF'
<script language="Javascript">
  alert("Date must be M(M)/D(D)/YYYY");
</script>
EOF;
    }
    $dt = $dtarray[2].'-'.$dtarray[0].'-'.$dtarray[1];
    $tm = $_POST['time'];
    $gym = $_POST['gym'];
    $home = $_POST['home'];
    $visitor = $_POST['visitor'];
    $edited = $_POST['edited'];
    $ref = $_POST['ref'];
    if ($ref == '') {
        $ref = 0;
    }
    $h1 = $_POST['h1'];
    if ($h1 == '') {
        $h1 = null;
    }
    $h2 = $_POST['h2'];
    if ($h2 == '') {
        $h2 = null;
    }
    $h3 = $_POST['h3'];
    if ($h3 == '') {
        $h3 = null;
    }
    $v1 = $_POST['v1'];
    if ($v1 == '') {
        $v1 = null;
    }
    $v2 = $_POST['v2'];
    if ($v2 == '') {
        $v2 = null;
    }
    $v3 = $_POST['v3'];
    if ($v3 == '') {
        $v3 = null;
    }
    $notes = $_POST['notes'];

    $sql2 = '';
    $hmp = $vmp = null;
    if (($h1 != null) && ($v1 != null)) {
        if ($h1 == null) {
            $h1 = 0;
        }
        if ($v1 == null) {
            $v1 = 0;
        }
        if ($h2 == null) {
            $h2 = 0;
        }
        if ($v2 == null) {
            $v2 = 0;
        }
        if ($h3 == null) {
            $h3 = 0;
        }
        if ($v3 == null) {
            $v3 = 0;
        }

        $hmp = $vmp = 0;
        if ($h1 != $v1) {
            // 0.5 match points per game
      $h1 > $v1 ? $hmp += 0.5 : $vmp += 0.5;
        }
        if ($h2 != $v2) {
            // 0.5 match points per game
      $h2 > $v2 ? $hmp += 0.5 : $vmp += 0.5;
        }
        if ($h3 != $v3) {
            // 0.5 match points per game
      $h3 > $v3 ? $hmp += 0.5 : $vmp += 0.5;
        }
        if ($hmp != $vmp) {
            // 2 points for winning the most games
      $hmp > $vmp ? $hmp += 2 : $vmp += 2;
        }

        $hsum = $h1 + $h2 + $h3;
        $vsum = $v1 + $v2 + $v3;
        if ($hsum != $vsum) {
            // 1 point for scoring the most game points in the match
      $hsum > $vsum ? $hmp += 1 : $vmp += 1;
        }

        $sql2 = <<<EOF
hscore1=$h1, hscore2=$h2, hscore3=$h3,
vscore1=$v1, vscore2=$v2, vscore3=$v3,
hmp=$hmp, vmp=$vmp,
EOF;
    } else {
        $sql2 = <<<'EOF'
hscore1=NULL, hscore2=NULL, hscore3=NULL,
vscore1=NULL, vscore2=NULL, vscore3=NULL,
hmp=NULL, vmp=NULL,
EOF;
    }

    $sql = <<<EOF
UPDATE games
SET dt='$dt', tm='$tm', gym=$gym, home=$home, visitor=$visitor, edited=$edited, ref=$ref,
$sql2 notes='$notes'
WHERE id=$id
EOF;

    if (!dbquery($sql)) {
        $error = dberror();
        echo "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
    } else {
        echo 'This game has been successfully edited.  <a href="games_add.php">return to list</a>';
    }
}

$sql = <<<EOF
SELECT t.id AS home, teams.id AS visitor, gyms.id AS gym,
dt, tm, s.edited AS edited, refs.id AS ref,
s.hscore1 AS h1, s.vscore1 AS v1,
s.hscore2 AS h2, s.vscore2 AS v2,
s.hscore3 AS h3, s.vscore3 AS v3,
s.notes AS notes
FROM ((((games s LEFT JOIN teams ON teams.id=s.visitor)
LEFT JOIN gyms ON gyms.id=s.gym) LEFT JOIN teams t ON t.id=s.home)
LEFT JOIN refs on refs.id=s.ref )
WHERE s.id=$id
EOF;

if ($result = dbquery($sql)) {
    $row_cnt = mysqli_num_rows($result);
    if ($row_cnt == 0) {
        echo '<div style="width: 750px; font-weight: bold; text-align: center;">There are no games to display.</div>';
    } else {
        $row = mysqli_fetch_assoc($result);
        $home = $row['home'];
        $visitor = $row['visitor'];
        $gym = $row['gym'];
        $dt = $row['dt'];
        $tm = $row['tm'];
        $edited = $row['edited'];
        $ref = $row['ref'];
        $h1 = $row['h1'];
        $v1 = $row['v1'];
        $h2 = $row['h2'];
        $v2 = $row['v2'];
        $h3 = $row['h3'];
        $v3 = $row['v3'];
        $notes = $row['notes'];

        echo <<<'EOF'
<form name="editEvent" class="eventForm" method="post">
<table>
<tr>
  <td>Home Team:</td>
  <td>
    <select name="home">
    <option value=""> -- Select -- </option>
EOF;

        $teams = getTeams();

        foreach ($teams as $team => $t) {
            $selected = '';
            if ($home == $t['id']) {
                $selected = ' selected="selected"';
            }
            echo <<<EOF
<option value="{$t['id']}"$selected>$team</option>
EOF;
        }

        echo <<<EOF
</select>
Scores:
Game 1 <input type="text" size="2" name="h1" value="$h1" \>
Game 2 <input type="text" size="2" name="h2" value="$h2" \>
Game 3 <input type="text" size="2" name="h3" value="$h3" \>
EOF;

        echo <<<'EOF'
  </td>
</tr>
<tr>
  <td>Visitor:</td>
  <td>
    <select name="visitor">
    <option value=""> -- Select -- </option>
EOF;

        foreach ($teams as $team => $t) {
            $selected = '';
            if ($visitor == $t['id']) {
                $selected = ' selected="selected"';
            }
            echo <<<EOF
<option value="{$t['id']}"$selected>$team</option>
EOF;
        }

        $dtarray = explode('-', $dt);
        $dat = $dtarray[1].'/'.$dtarray[2].'/'.$dtarray[0];
        $tm_array = explode(':', $tm);
        $tim = sprintf('%d:%02d', $tm_array[0], $tm_array[1]);

        echo <<<EOF
</select>
Scores:
Game 1 <input type="text" size="2" name="v1" value="$v1">
Game 2 <input type="text" size="2" name="v2" value="$v2">
Game 3 <input type="text" size="2" name="v3" value="$v3">
  </td>
</tr>
<tr>
  <td>Date:</td>
  <td><input type="text" name="date" value="$dat" /></td>
</tr>
<tr>
  <td>Time:</td>
  <td><input type="text" name="time" value="$tim" /></td>
</tr>
<tr>
<td>Location:</td>
<td>
  <select name="gym">
  <option value=""> -- Select -- </option>
EOF;

        $gyms = getGyms();

        foreach ($gyms as $gym2 => $g) {
            $selected = '';
            if ($gym == $g['id']) {
                $selected = ' selected="selected"';
            }
            echo <<<EOF
<option value="{$g['id']}"$selected>$gym2</option>
EOF;
        }

        $selectedYes = '';
        $selectedNo = ' selected="selected"';
        if ($edited == 1) {
            $selectedYes = ' selected="selected"';
            $selectedNo = '';
        }

        echo <<<EOF
  </select>
</td>
</tr>
<tr>
  <td>Show as edited?</td>
  <td>
    <select name="edited">
    <option value="1"$selectedYes>Yes</option>
    <option value="0"$selectedNo>No</option>
    </select>
  </td>
</tr>
<tr>
  <td>Referee:</td>
  <td>
    <select name="ref">
    <option value=""> -- Select -- </option>
EOF;

        $refs = getRefs();

        foreach ($refs as $ref2 => $r) {
            $selected = '';
            if ($ref == $r['id']) {
                $selected = ' selected="selected"';
            }
            echo <<<EOF
<option value="{$r['id']}"$selected>$ref2</option>
EOF;
        }

        $notes = htmlentities($notes);

        echo <<<EOF
    </select>
  </td>
</tr>
<tr>
  <td>Notes:</td>
  <td><textarea name="notes" cols="40" rows="5">$notes</textarea></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td><input type="submit" value="Edit Game"></td>
</tr>
</table>
<input type="hidden" name="id" value="$id" />
</form>

<form action="games_add.php" name="delete" style="margin-left: 70px;" method="post">
<input type="hidden" name="delete" value="yes" />
<input type="hidden" name="id" value="$id" />
<input type="submit" value="Delete this game" onclick="javascript:return confirm('Really delete this game?')">
</form>

</body>
</html>
EOF;
    }

    mysqli_free_result($result);
} else {
    $error = dberror();
    echo "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
}

dbclose();
