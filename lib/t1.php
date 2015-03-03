#!/usr/bin/php

<?php

include '/home/pva/portlandvolleyball.org/lib/mysql.php';
include '/home/pva/portlandvolleyball.org/lib/support.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

/****************************************************************/

$gyms=getGyms();
foreach($gyms as $gym => $g) {
  print <<<EOF
$gym [id={$g['id']}]\n
EOF;
}
print "************************************************\n";

/****************************************************************/

$active=1;
$leagues=getLeagues($active);
foreach($leagues as $league => $l) {
  print "$league [id={$l['id']}]\n";
}
print "************************************************\n";

/****************************************************************/

$refs=getRefs();
foreach($refs as $ref => $r) {
  print <<<EOF
$ref [id={$r['id']}]\n
EOF;
}
print "************************************************\n";

/****************************************************************/

$teams=getTeams();
foreach ($teams as $team => $t) {
  print "$team ({$t['league']}) [id={$t['id']}]\n";
}
print "************************************************\n";

/****************************************************************/

dbclose();

?>
