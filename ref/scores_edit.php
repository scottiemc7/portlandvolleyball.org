<?php   //This file is the score-editing page for
  //a particular game for the logged-in ref

include 'header.html';

include '../lib/mysql.php';

$ref = $HTTP_SESSION_VARS['ref'];

$h1 = null;
if (isset($_POST['h1'])) {
    $_POST['h1'] = preg_replace('/[^\d]/', '', $_POST['h1']);
    if (is_numeric($_POST['h1'])) {
        $h1 = $_POST['h1'];
    }
}
$h2 = null;
if (isset($_POST['h2'])) {
    $_POST['h2'] = preg_replace('/[^\d]/', '', $_POST['h2']);
    if (is_numeric($_POST['h2'])) {
        $h2 = $_POST['h2'];
    }
}
$h3 = null;
if (isset($_POST['h3'])) {
    $_POST['h3'] = preg_replace('/[^\d]/', '', $_POST['h3']);
    if (is_numeric($_POST['h3'])) {
        $h3 = $_POST['h3'];
    }
}
$v1 = null;
if (isset($_POST['v1'])) {
    $_POST['v1'] = preg_replace('/[^\d]/', '', $_POST['v1']);
    if (is_numeric($_POST['v1'])) {
        $v1 = $_POST['v1'];
    }
}
$v2 = null;
if (isset($_POST['v2'])) {
    $_POST['v2'] = preg_replace('/[^\d]/', '', $_POST['v2']);
    if (is_numeric($_POST['v2'])) {
        $v2 = $_POST['v2'];
    }
}
$v3 = null;
if (isset($_POST['v3'])) {
    $_POST['v3'] = preg_replace('/[^\d]/', '', $_POST['v3']);
    if (is_numeric($_POST['v3'])) {
        $v3 = $_POST['v3'];
    }
}

$id = preg_replace('/[^\d]/', '', $_POST['game_id']);
if (isset($_GET['id'])) {
    $game = preg_replace('/[^\d]/', '', $_GET['id']);
} else {
    $game = $id;
}

$notes = $_POST['notes'];

if (($h1 != null) || ($v1 != null)) {
    $hpts = 0;
    $vpts = 0;
    if ($h1 != $v1) {
        $h1 > $v1 ? $hpts += 0.5 : $vpts += 0.5;  // 0.5 match points per game
    }
    if ($h2 != $v2) {
        $h2 > $v2 ? $hpts += 0.5 : $vpts += 0.5;
    }
    if ($h3 != $v3) {
        $h3 > $v3 ? $hpts += 0.5 : $vpts += 0.5;
    }
    if ($hpts != $vpts) {
        $hpts > $vpts ? $hpts += 2 : $vpts += 2;  // 2 points for winning the most games
    }
    $hsum = $h1 + $h2 + $h3;
    $vsum = $v1 + $v2 + $v3;
    if ($hsum != $vsum) {
        $hsum > $vsum ? $hpts += 1 : $vpts += 1;  // 1 point for scoring the most game points in the match
    }
} else {
    $hpts = $vpts = 0;
}

$error = dbinit();
if ($error !== '') {
    echo "***ERROR*** dbinit: $error\n";
    exit;
}

$notes = dbescape($notes);

if ($_POST['submit']) {
    $sql = <<<EOF
UPDATE games SET hscore1=$h1, hscore2=$h2, hscore3=$h3, vscore1=$v1, vscore2=$v2, vscore3=$v3, hmp=$hpts, vmp=$vpts, notes='$notes' WHERE id=$id
EOF;

    if (dbquery($sql)) {
        echo <<<'EOF'
This score has been successfully edited.
<a href="index.php">return to ref home</a>
EOF;
    } else {
        $error = dberror();
        echo "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
    }
}

$sql = <<<EOF
SELECT g.hscore1 AS h1, g.vscore1 AS v1, g.hscore2 AS h2, g.vscore2 AS v2, g.hscore3 AS h3, g.vscore3 AS v3,
t.name AS home, teams.name AS visitor, g.notes AS notes
FROM ((games g LEFT JOIN teams t ON t.id = g.home) LEFT JOIN teams ON teams.id = g.visitor)
WHERE g.id = $game
EOF;

if ($result = dbquery($sql)) {
    $row_cnt = mysqli_num_rows($result);

    if ($row_cnt == 0) {
        echo <<<EOF
game is $game
EOF;
        die('Invalid query');
    } else {
        $row = mysqli_fetch_assoc($result);
        $h1 = $row['h1'];
        $v1 = $row['v1'];
        $h2 = $row['h2'];
        $v2 = $row['v2'];
        $h3 = $row['h3'];
        $v3 = $row['v3'];
        $home = $row['home'];
        $visitor = $row['visitor'];
        $notes = $row['notes'];

        echo <<<EOF
<form action="scores_edit.php" method="post">
<table class="eventTable" cellspacing="0" style="width: 60%; text-align: center;">
<tr>
  <td>&nbsp;</td>
  <td>Game 1</td>
  <td>Game 2</td>
  <td>Game 3</td>
</tr>
<tr><td>$home (Home)</td>
  <td><input type="text" size="3" name="h1" value="$h1"></td>
  <td><input type="text" size="3" name="h2" value="$h2"></td>
  <td><input type="text" size="3" name="h3" value="$h3"></td>
</tr>
<tr><td>$visitor (Visitors)</td>
  <td><input type="text" size="3" name="v1" value="$v1"></td>
  <td><input type="text" size="3" name="v2" value="$v2"></td>
  <td><input type="text" size="3" name="v3" value="$v3"></td>
</tr>
</table>
<span style="position: relative; left: 10%; top: 20px;">Game notes:<br />
<textarea name="notes" rows="5" cols="40">$notes</textarea>
<input type="hidden" name="game_id" value="$game">
<br />
<input type="submit" name="submit" value="submit">
</span>
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

?>

</body>
</html>
