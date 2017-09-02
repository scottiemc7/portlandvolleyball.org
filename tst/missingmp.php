<?php

include '/home/pva/portlandvolleyball.org/lib/mysql.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

$BYE_GYM = 42;
$CANCELLED_GYM = 43;
$BYE_TEAM = 457;
                
$sql=<<<EOF
SELECT home,visitor,hscore1,vscore1,hscore2,vscore2,hscore3,vscore3,hmp,vmp,dt
FROM games
WHERE visitor <> $BYE_TEAM
AND gym <> $BYE_GYM
AND gym <> $CANCELLED_GYM
AND (hscore1>0 OR vscore1>0)
AND hmp<0.1
AND vmp<0.1
ORDER BY dt
EOF;
                
if($result=dbquery($sql)) {
                
  while($row=mysqli_fetch_assoc($result)) {
    $home=$row['home'];
    $visitor=$row['visitor'];
    $hscore1=$row['hscore1'];
    $vscore1=$row['vscore1'];
    $hscore2=$row['hscore2'];
    $vscore2=$row['vscore2'];
    $hscore3=$row['hscore3'];
    $vscore3=$row['vscore3'];
    $hmp=$row['hmp'];
    $vmp=$row['vmp'];
    $dt=$row['dt'];
    
    print <<<EOF
h=$home v=$visitor ($hscore1-$vscore1) ($hscore2-$vscore2) ($hscore3-$vscore3) [$hmp,$vmp] $dt<p />
EOF;
  }
  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

dbclose();

?>
