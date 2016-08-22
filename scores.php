<?php

include("header.html");
print '<div id="content" class="container">';
include 'lib/mysql.php';

$leagues = $_POST['leagues'];
$teams = $_POST['teams'];

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

$sql=<<<EOF
SELECT t.id AS id, t.name AS team, l.name AS league
FROM teams t
JOIN leagues l on t.league=l.id
WHERE l.active=1
ORDER BY t.name
EOF;

if(! $qryTeams=dbquery($sql)) {
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

$sql=<<<EOF
SELECT * FROM leagues WHERE active=1 ORDER BY name
EOF;

if(! $qryLeagues=dbquery($sql)) {
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

print <<<EOF
<h1>Scores for completed games</h1>

<p>To filter, choose one of the options below, and click "Filter".</p>

<form class="form-inline" name="sort" method="post">
  <div class="form-group">
	<select class="form-control" name="teams" onchange="document.sort.leagues.selectedIndex = 0;">
	<option value="">-- Select team --</option>

EOF;

while($row=mysqli_fetch_assoc($qryTeams)) {
  $id=$row['id'];
  $name=$row['team'];
  $league=$row['league'];
  print <<<EOF
<option value="$id">$name ($league)</option>
EOF;
}
mysqli_free_result($qryTeams);

print <<<EOF
</select>
</div>
<div class="form-group">
<select class="form-control"name="leagues" onchange="document.sort.teams.selectedIndex = 0;">
<option value="">-- Select league --</option>
EOF;

while($row=mysqli_fetch_assoc($qryLeagues)) {
  $id=$row['id'];
  $name=$row['name'];
  print <<<EOF
<option value="$id">$name</option>
EOF;
}
mysqli_free_result($qryLeagues);

?>
</select>
</div>
<input type="submit" value="filter" class="btn btn-default" />
</form>
<br />
<div class="table-responsive">
<table class="table table-striped">
<tr>
<th>Date</th>
<th>Time</th>
<th>League</th>
<th>Home</th>
<th>Visitor</th>
<th>Game 1</th>
<th>Game 2</th>
<th>Game 3</th>
</tr>
<tr>
<td colspan="8">
<div style="font-weight: normal; font-size: smaller; float: right; margin-right: 15%;">
Scores are shown 'home - visitor'
</div>
</td>
</tr>

<?php

$where="";

if(isset($leagues) && ($leagues > 0))
  $where.=" AND (t.league=$leagues OR teams.league=$leagues)";

if(isset($teams) && ($teams > 0))
  $where.=" AND (t.id=$teams OR teams.id=$teams)";

$sql=<<<EOF
SELECT DATE_FORMAT(dt, '%c/%d (%a)') as dt1, tm,
g.hscore1 AS h1, g.hscore2 AS h2, g.hscore3 AS h3,
g.vscore1 AS v1, g.vscore2 AS v2, g.vscore3 AS v3,
t.name AS home, teams.name AS visitor, l.name AS league
FROM ((((games g)
LEFT JOIN teams t ON t.id = g.home)
LEFT JOIN teams ON teams.id = g.visitor)
LEFT JOIN leagues l ON t.league = l.id)
WHERE g.hscore1 IS NOT NULL $where
ORDER BY dt, tm
EOF;

if($result=dbquery($sql)) {
  $row_cnt=mysqli_num_rows($result);

  if($row_cnt==0) {
    print <<<EOF
<tr><td><div style="font-size: larger; color: #0000dd;">No results to display</div></td></tr>
EOF;
  }else{
    while($row=mysqli_fetch_assoc($result)) {
      $dt=$row['dt1'];
      $tm=$row['tm'];
      $h1=$row['h1'];
      $h2=$row['h2'];
      $h3=$row['h3'];
      $v1=$row['v1'];
      $v2=$row['v2'];
      $v3=$row['v3'];
      $home=$row['home'];
      $visitor=$row['visitor'];
      $league=$row['league'];

      print <<<EOF
<tr>
<td>$dt</td><td>$tm</td>
<td>$league</td>
<td>$home</td><td>$visitor</td>
<td>$h1 - $v1</td><td>$h2 - $v2</td>
<td>$h3 - $v3</td>
</tr>

EOF;
    }
  }

  mysqli_free_result($result);

}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

dbclose();

?>

</table>
</div>
</body>
</html>
