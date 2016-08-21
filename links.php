<?php

include 'header.html';
include 'lib/mysql.php';

$error = dbinit();
if ($error !== '') {
    echo "***ERROR*** dbinit: $error\n";
    exit;
}

$sql = <<<'EOF'
SELECT * FROM linkage
EOF;

if ($result = dbquery($sql)) {
    $row_cnt = mysqli_num_rows($result);
    if ($row_cnt == 0) {
        echo <<<'EOF'
<div style="width: 750px; font-weight: bold; text-align: center;">There are no links to display.</div>
EOF;
    } else {
        echo <<<'EOF'
<h1>Volleyball Links</h1>
<table class="interiorTable" cellspacing="0">
<tr>
  <th>Link</th>
  <th>Description</th>
</tr>
EOF;

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $link = $row['link'];
            $linktext = $row['linktext'];
            $description = $row['description'];

            echo <<<EOF
<tr>
  <td nowrap valign="top"><a href="$link">$linktext</a></td>
  <td valign="top">$description</td>
</tr>
EOF;
        }

        echo "</table>\n";
    }

    mysqli_free_result($result);
} else {
    $error = dberror();
    echo "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
}

dbclose();

include 'footer.html';
