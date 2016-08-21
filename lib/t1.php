#!/usr/bin/php

<?php

include '../lib/mysql.php';
include '../lib/support.php';

$error = dbinit();
if ($error !== '') {
    echo "***ERROR*** dbinit: $error\n";
    exit;
}

/****************************************************************/

$gyms = getGyms();
foreach ($gyms as $gym => $g) {
    echo <<<EOF
$gym [id={$g['id']}]\n
EOF;
}
echo "************************************************\n";

/****************************************************************/

$active = 1;
$leagues = getLeagues($active);
foreach ($leagues as $league => $l) {
    echo "$league [id={$l['id']}]\n";
}
echo "************************************************\n";

/****************************************************************/

$refs = getRefs();
foreach ($refs as $ref => $r) {
    echo <<<EOF
$ref [id={$r['id']}]\n
EOF;
}
echo "************************************************\n";

/****************************************************************/

$teams = getTeams();
foreach ($teams as $team => $t) {
    echo "$team ({$t['league']}) [id={$t['id']}]\n";
}
echo "************************************************\n";

/****************************************************************/

dbclose();

?>
