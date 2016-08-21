<?php include 'header.html'; ?>


<?php

include 'lib/mysql.php';

$error = dbinit();
if ($error !== '') {
    echo "***ERROR*** dbinit: $error\n";
    exit;
}

$sql = <<<'EOF'
SELECT * FROM events ORDER BY dt,tm ASC
EOF;

if ($result = dbquery($sql)) {
    $row_cnt = mysqli_num_rows($result);
    if ($row_cnt > 0) {
        echo <<<'EOF'
<h1>PVA Schedule of Events</h1>
<table class="interiorTable" cellspacing="0">
<tr>
<th>Date/Time</th>
<th>Event</th>
<th>Comments</th>
</tr>
EOF;

        while ($row = mysqli_fetch_assoc($result)) {
            $dtarray = explode('-', $row['dt']);
            $dt = sprintf('%d/%d/%d', $dtarray[1], $dtarray[2], $dtarray[0]);

            $tmarray = explode(':', $row['tm']);
            $tm = sprintf('%d:%02d', $tmarray[0], $tmarray[1]);

            $title = $row['title'];

            $desc = $row['description'];
            if (!empty($row['link'])) {
                $link = $row['link'];
                $desc .= <<<EOF
<br /><a href="$link">more information</a>
EOF;
            }

            echo <<<EOF
<tr>
  <td nowrap valign="top">$dt<br />$tm</td>
  <td valign="top">$title</td>
  <td valign="top">$desc</td>
</tr>
EOF;
        }

        mysqli_free_result($result);

        echo <<<'EOF'
</table>
EOF;
    } else {
        echo <<<'EOF'
<div style="width: 750px; font-weight: bold; text-align: center;">
There are no events to display.
</div>
EOF;
    }
} else {
    $error = dberror();
    echo "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
}

dbclose();

?>

<?php include 'footer.html'; ?>
