<?php

include("header.html");
include '../lib/mysql.php';
include '../lib/support.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

if($_POST['delete'] != "") {
  $id=preg_replace('/[^\d]/','',$_POST['id']);
  if(!dbquery("DELETE FROM games WHERE id=$id")) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}

if($_POST['deleteall'] != "") {
  if(!dbquery("DELETE FROM games WHERE 1")) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}

if(isset($_POST['home'])) {
  $dtarray = explode('/',$_POST['dt']);
  $dt = $dtarray[2] . '-' . $dtarray[0] . '-' . $dtarray[1];
  $tm = $_POST['time'];
  $gym = $_POST['gym'];
  $court = $_POST['court'];
  $home = $_POST['home'];
  $visitor = $_POST['visitor'];
  $ref = $_POST['ref'];

  $sql=<<<EOF
INSERT INTO games (dt, tm, gym, court, home, visitor, ref)
VALUES ('$dt', '$tm', $gym, '$court', $home, $visitor, '$ref')
EOF;
  if(!dbquery($sql)) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}

print <<<EOF
<h1>Add Game</h1>

<p>Note: In order to add a game, the teams and gym location must already be in the database.</p>

<form name="addTeam" class="eventForm" method="post">
<table>
<tr>
  <td>Home Team:</td>
  <td>
    <select name="home">
    <option value=""> -- Select -- </option>
EOF;

$sql=<<<EOF
SELECT t.id AS id, t.name AS team, l.name AS league
FROM (teams t LEFT JOIN leagues l ON l.id = t.league)
ORDER BY l.name, t.name
EOF;

$str="";
if($result=dbquery($sql)) {

  while($row=mysqli_fetch_assoc($result)) {
    $id=$row['id'];
    $team=htmlentities($row['team']);
    $league=$row['league'];

    $str.=<<<EOF
    <option value="$id">$team ($league)</option>
EOF;
  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

print <<<EOF
    $str
    </select>
  </td>
</tr>
<tr>
  <td>Visitor:</td>
  <td>
    <select name="visitor">
    <option value=""> -- Select -- </option>
    $str
    </select>
  </td>
</tr>
<tr>
  <td>Date:(MM/DD/YYYY)</td>
  <td><input type="text" name="dt">
</tr>
<tr>
  <td>Time:</td>
  <td>
    <select name="time">
    <option value="2:00">2:00</option>
    <option value="2:30">2:30</option>
    <option value="3:00">3:00</option>
    <option value="3:30">3:30</option>
    <option value="4:00">4:00</option>
    <option value="4:30">4:30</option>
    <option value="5:00">5:00</option>
    <option value="5:30">5:30</option>
    <option value="6:15">6:15</option>
    <option value="6:30">6:30</option>
    <option value="6:45">6:45</option>
    <option value="7:00">7:00</option>
    <option value="7:15">7:15</option>
    <option value="7:30">7:30</option>
    <option value="7:45">7:45</option>
    <option value="8:00">8:00</option>
    <option value="8:15">8:15</option>
    <option value="8:30">8:30</option>
    <option value="9:00">9:00</option>
    <option value="9:15">9:15</option>
    <option value="9:30">9:30</option>
    </select>
  </td>
</tr>
<tr>
  <td>Location:</td>
  <td>
    <select name="gym">
    <option value=""> -- Select -- </option>
EOF;

$gyms=getGyms();

foreach($gyms as $gym => $g) {
  print <<<EOF
<option value="{$g['id']}">$gym</option>
EOF;
}

print <<<EOF
    </select>
  </td>
</tr>
</tr>
  <td>Court:</td>
  <td><input type="text" name="court">
</tr>
<tr>
  <td>Referee:</td>
  <td>
    <select name="ref">
    <option value=""> -- Select -- </option>
EOF;

$refs=getRefs();

foreach($refs as $ref => $r) {
  print <<<EOF
<option value="{$r['id']}">$ref</option>
EOF;
}

print <<<EOF
</tr>
<tr>
  <td>&nbsp;</td>
  <td><input type="submit" value="Add Game"></td>
</tr>
</table>
</form>

<h1>Current Games</h1>
<table cellpadding="6" cellspacing="0" width="750" class="eventTable games-table">
<tr>
  <th>Date</th>
  <th>Time</th>
  <th>Home</th>
  <th>Visitor</th>
  <th>Winner</th>
  <th>Location</th>
  <th>Court</th>
  <th>Referee</th>
  <th>Notes</th>
  <th>&nbsp;</th>
</tr>
EOF;

$sql=<<<EOF
SELECT teams.name AS visitor, t.name AS home, gyms.name AS gym, s.court AS court,
dt, tm, s.id AS id, s.edited AS edited, refs.fname AS fname,
refs.lname AS lname, refs.id AS refid, s.hmp AS hmp, s.vmp AS vmp,
s.hscore1 AS h1, s.vscore1 AS v1, s.notes AS notes
FROM ((((games s LEFT JOIN teams ON teams.id = s.visitor)
LEFT JOIN gyms ON gyms.id = s.gym) LEFT JOIN teams t ON t.id = s.home)
LEFT JOIN refs ON refs.id = s.ref )
ORDER BY dt, tm
EOF;

if($result=dbquery($sql)) {

  while($row=mysqli_fetch_assoc($result)) {
    $visitor=htmlentities($row['visitor']);
    $home=htmlentities($row['home']);
    $gym=$row['gym'];
    $court=$row['court'];
    $dt=$row['dt'];
    $tm=$row['tm'];
    $id=$row['id'];
    $edited=$row['edited'];
    $fname=$row['fname'];
    $lname=$row['lname'];
    $refid=$row['refid'];
    $hmp=$row['hmp'];
    $vmp=$row['vmp'];
    $h1=$row['h1'];
    $v1=$row['v1'];
    $notes=$row['notes'];

    $dtarray = explode('-', $dt);
    $date=sprintf("%d/%d/%d", $dtarray[1], $dtarray[2], $dtarray[0]);
    $tmarray = explode(':', $tm);
    $time=sprintf("%d:%02d", $tmarray[0], $tmarray[1]);

    $style="";
    if($edited!=0) {
      $style=' style="background-color: #ffff99;"';
    }

    print <<<EOF
<tr$style class="games-table__row">
<td valign="top">$date</td>
<td valign="top">$time</td>
<td valign="top">$home</td>
<td valign="top">$visitor</td>
<td valign="top">
EOF;

    if($visitor == "BYE" || $home == "BYE" || $gym == "BYE" || $gym == "Cancelled") {
      print '<span style="text-align: center;">N/A</span>';
    }elseif(($h1==NULL && $v1==NULL) && strtotime($dt) < time() - 86400) {
      // If the first game has no score and the date is past, we need a score
      print '<span style="color: #ff0000;">Need score</span>';
    }else{
      // Otherwise, choose match winner on match points
      if($hmp != $vmp){
        $hmp>$vmp ? $msg=$home : $msg=$visitor;
        print "$msg";
      }
      print  "&nbsp;";
    }
    print <<<EOF
</td>
  <td valign="top">$gym</td>
  <td valign="top">$court</td>
  <td valign="top">$fname $lname &nbsp;</td>
  <td valign="top">$notes &nbsp;</td>
  <td>
    <form action="games_edit.php" method="post">
    <input type="submit" value="Edit">
    <input type="hidden" name="id" value="$id" />
    <input type="hidden" name="ref" value="$refid" />
    </form>
  </td>
</tr>
EOF;

  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

print <<<EOF
</table>

<p>
  <form method="post" onclick="javascript: return confirm('This can not be undone!  Are you sure you want to delete all games?');">
    <input type="submit" value="Delete all games" />
    <input type="hidden" name="deleteall" value="true" />
  </form>
</p>

</body>
</html>
EOF;

dbclose();

?>
