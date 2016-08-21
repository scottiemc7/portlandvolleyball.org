<?php   //This file is the primary page for referees,
  //provide a list of games to choose for editing

include("header.html");

include '../lib/mysql.php';

$ref = $_SESSION['ref'];

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

$sql=<<<EOF
SELECT teams.name AS visitor, t.name AS home, gyms.name AS gym1,
DATE_FORMAT(dt, '%c/%d (%a)') as dt2, tm, s.court AS court,
s.hscore1 AS hscore1, s.vscore1 AS vscore1,
s.hscore2 AS hscore2, s.vscore2 AS vscore2,
s.hscore3 AS hscore3, s.vscore3 AS vscore3,
s.id AS id, s.gym AS gymID, l.name AS league
FROM (((games s LEFT JOIN teams ON teams.id = s.visitor)
LEFT JOIN gyms ON gyms.id = s.gym)
LEFT JOIN teams t ON t.id = s.home)
LEFT JOIN leagues l on l.id = t.league
WHERE s.ref = $ref
ORDER BY dt, tm
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  if($row_cnt > 0) {

    print <<<EOF
<table class="eventTable" cellspacing="0" cellpadding="6" width="100%">
<tr>
<th>Date / League</th>
<th>Time</th>
<th>Location</th>
<th>Court</th>
<th>Teams</th>
<th>Game 1</th>
<th>Game 2</th>
<th>Game 3</th>
<th>&nbsp;</th>
</tr>

EOF;

    while($row=mysqli_fetch_assoc($result)) {
      $visitor=$row['visitor'];
      $home=$row['home'];
      $gym1=$row['gym1'];
      $dt=$row['dt2'];
      $tm=$row['tm'];
      $court=$row['court'];
      $vscore1=$row['vscore1'];
      $hscore1=$row['hscore1'];
      $vscore2=$row['vscore2'];
      $hscore2=$row['hscore2'];
      $vscore3=$row['vscore3'];
      $hscore3=$row['hscore3'];
      $id=$row['id'];
      $gymID=$row['gymID'];
      $league=$row['league'];
      print <<<EOF
<tr>
<td rowspan="2" nowrap="nowrap">$dt<br />$league &nbsp;</td>
<td rowspan="2">$tm&nbsp;</td>
<td rowspan="2"><a href="../gyms.php?id=$gymID">$gym1</a>&nbsp;</td>
<td rowspan="2">$court&nbsp;</td>
<td>$home&nbsp;(Home)</td>
<td>$hscore1&nbsp;</td>
<td>$hscore2&nbsp;</td>
<td>$hscore3&nbsp;</td>
<td rowspan="2"><a href="scores_edit.php?id=$id"><div style="text-align: center;">Edit scores</div></a></tr>
<tr><td>$visitor&nbsp;(Visitor)</td>
<td>$vscore1&nbsp;</td>
<td>$vscore2&nbsp;</td>
<td>$vscore3&nbsp;</td>
</tr>

EOF;
    }

    print <<<EOF
</table>
EOF;

  }else{
    print <<<EOF
<div style="font-size: larger; font-weight: bold; color: #ff0000; text-align: center; margin-top: 80px;">
You have no games assigned.
</div>
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
</body>
</html>
