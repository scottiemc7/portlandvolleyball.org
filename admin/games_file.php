<?php

include '../lib/mysql.php';

session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    // Already logged in
} else {
    // Must be logged in first
  header('Location: login.php');
    exit;
}

$error = dbinit();
if ($error !== '') {
    echo "***ERROR*** dbinit: $error\n";
    exit;
}

$sql = <<<'EOF'
SELECT t.name AS home, teams.name AS visitor, gyms.name AS gym, 
dt, tm, s.id AS id, s.edited AS edited, 
refs.fname AS fname, refs.lname AS lname, refs.id AS refid, 
s.hmp AS hmp, s.vmp AS vmp, s.hscore1 AS h1, s.vscore1 AS v1, s.notes AS notes
FROM ((((games s LEFT JOIN teams ON teams.id = s.visitor) LEFT JOIN gyms ON gyms.id = s.gym) LEFT JOIN teams t ON t.id = s.home) LEFT JOIN refs ON refs.id = s.ref ) 
ORDER BY dt, tm
EOF;

$contents = '';
if ($result = dbquery($sql)) {
    $row_cnt = mysqli_num_rows($result);
    if ($row_cnt > 0) {
        $contents = "Date\tTime\tHome\tVisitor\tWinner\tLocation\tReferee\tNote\n";
        while ($row = mysqli_fetch_assoc($result)) {
            $home = $row['home'];
            $visitor = $row['visitor'];
            $gym = $row['gym'];
            $dt = $row['dt'];
            $tm = $row['tm'];
            $id = $row['id'];
            $edited = $row['edited'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $refid = $row['refid'];
            $hmp = $row['hmp'];
            $vmp = $row['vmp'];
            $h1 = $row['h1'];
            $v1 = $row['v1'];
            $notes = $row['notes'];

            $dtarray = explode('-', $dt);
            $contents .= sprintf("%d/%d/%d\t", $dtarray[1], $dtarray[2], $dtarray[0]);

            $tmarray = explode(':', $tm);
            $contents .= sprintf("%d:%02d\t", $tmarray[0], $tmarray[1]);

            $contents .= stripslashes($home)."\t";
            $contents .= stripslashes($visitor)."\t";

            if ($home == 'BYE' || $visitor == 'BYE' || $gym == 'BYE' || $gym == 'Cancelled') {
                $contents .= "N/A\t";
            } elseif (($h1 == null && $v1 == null) && strtotime($tm) < time() - 86400) {
                // If the first game has no score and the date is past, we need a score
        $contents .= "Need score\t";
            } else {
                // Otherwise, choose match winner on match points
        if ($hmp != $vmp) {
            $hmp > $vmp ? $msg = stripslashes($home) : $msg = stripslashes($visitor);
            $contents .= $msg."\t";
        } else {
            $contents .= " \t";
        }
            }

            $contents .= "$gym\t$fname $lname\t";

      // Remove nonprintable characters and clean up whitespace from note
      $notes = preg_replace('/[\x00-\x1F\x7F-\xFF]/', ' ', $notes);
            $notes = preg_replace('/ +/', ' ', $notes);
            $notes = preg_replace('/^ | $/', '', $notes);
            $contents .= $notes."\n";
        }
    } else {
        $contents = "There are no items to display.\n";
    }

    mysqli_free_result($result);
} else {
    $error = dberror();
    echo "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
}

dbclose();

//header("Content-type: application/octet-stream");
header('Content-type: application/vnd.ms-excel');
header('Content-disposition: attachment; filename=games.csv');
echo $contents;
