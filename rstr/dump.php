<?php

include '../header.html';

include 'lib/mysql.php';

$error = dbinit();
if ($error !== '') {
    echo "***ERROR*** dbinit: $error\n";
    exit;
}

if (isset($_GET['t']) and (!empty($_GET['t']))) {
    $table = $_GET['t'];

    $sql = <<<EOF
SELECT * FROM $table
EOF;

    if ($result = dbquery($sql)) {
        $row_cnt = mysqli_num_rows($result);

        if ($row_cnt == 0) {
            echo <<<'EOF'
<div style="width: 750px; font-weight: bold; text-align: center; padding: 50px;">There are no items to display.</div>
EOF;
        } else {
            echo <<<'EOF'
<table border="1">
EOF;

            $first = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                //ksort($row);
        if ($first == 1) {
            echo '<tr>';
            foreach ($row as $key => $value) {
                echo "<th>$key</th>";
            }
            echo "</tr>\n";
            $first = 0;
        }
                echo '<tr>';
                foreach ($row as $key => $value) {
                    if (strcmp($value, '') == 0) {
                        $value = '&nbsp;';
                    }
                    echo "<td>$value</td>";
                }
                echo "</tr>\n";
            }

            mysqli_free_result($result);

            echo <<<'EOF'
</table>
EOF;
        }
    } else {
        $error = dberror();
        echo "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
    }
} else {
    echo <<<'EOF'
<div style="width: 750px; font-weight: bold; text-align: center; padding: 50px;">No table specified.</div>
EOF;
}

dbclose();

?>

</body>
</html>
