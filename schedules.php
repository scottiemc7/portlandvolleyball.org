<?php include 'header.html.php'; ?>
<div id="content" class="container">
<?php
require_once 'lib/mysql.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

/*
SELECT t.id, t.name, league.name
FROM teams t
JOIN leagues league ON t.league=league.id WHERE league.active=1
ORDER BY t.name
*/
$sql=<<<EOF
SELECT t.id AS id, t.name AS team, l.name AS league
FROM teams t, leagues l
WHERE t.league=l.id
AND l.active=1
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

?>
	<h1>Schedules</h1>
	  <div class="row">
      <div class="col-md-6">
    		<p>
    		  To filter, choose one of the options below, and click "Filter".
    		  <br>
    			Games that have been changed are denoted with a <span style="background-color: #ffff99;">yellow background</span>.
    		</p>

    		<p>
    		  For scheduling questions, contact Michelle Baldwin at
    		  <script language="javascript">
    			document.write('<a href="mailto:' + getE('info', 'portlandvolleyball.org') + '">' + getE('info', 'portlandvolleyball.org') + '</a>.</p>');
    		</script>
      </p>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
    <p>
  <form name="sort" method="post" style="clear: both;" class="form-inline">
  <div class="form-group">
  	<select class="form-control" name="teams" onchange="document.sort.leagues.selectedIndex = 0;">
  	<option value="">-- Select team --</option>

<?php


while($row=mysqli_fetch_assoc($qryTeams)) {
  $id=$row['id'];
  $name=$row['team'];
  $league=$row['league'];
  $selected = $id == $teams;
  print <<<EOF
<option value="$id">$name ($league)</option>
EOF;
}

mysqli_free_result($qryTeams);

?>
	</select>
  </div>
  <div class="form-group">
	<select class="form-control" name="leagues" onchange="document.sort.teams.selectedIndex = 0;">
	<option value="">-- Select league --</option>
<?php

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
	<input type="submit" value="Filter" class="btn btn-default"/>
</form>
<p>
</div>
</div>
<div class="table-responsive">
<table class="table table-striped table-condensed schedule-table">
	<tr>
		<th>Date</th>
		<th>Time</th>
		<th>Home</th>
		<th>Visitor</th>
		<th>Location (Ref)</th>
		<th>League</th>
	</tr>
<?php

$leagues = $_POST["leagues"];
$teams = $_POST["teams"];
$where = "where dt >= curdate()";

if(isset($leagues) && ($leagues > 0))
  $where.=" AND (home.league=$leagues OR visitor.league=$leagues)";

if(isset($teams) && ($teams > 0))
  $where.=" AND (home.id=$teams OR visitor.id=$teams)";

$sql=<<<EOF
SELECT DATE_FORMAT(dt, '%c/%d (%a)') as dt, tm, home.name AS h, visitor.name AS v, gym.id AS gymID, gym.name AS gymName, ref.fname AS ref_name, court, edited, l.name AS league
FROM games g
JOIN teams home on g.home = home.id
JOIN teams visitor on g.visitor = visitor.id
JOIN gyms gym on gym.id = g.gym
LEFT JOIN refs ref on ref.id = g.ref
JOIN leagues l on l.id = home.league
$where
ORDER BY g.dt, g.tm
EOF;

echo $sql;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);

  while($row=mysqli_fetch_assoc($result)) {
    $dt=$row['dt'];
    $tm=$row['tm'];
    $home=stripslashes($row['h']);
    $visitor=stripslashes($row['v']);
    $gymID=$row['gymID'];
    $gym=$row['gymName'];
    $ref_name=$row['ref_name'];
    $court=$row['court'];
    $edited=$row['edited'];
    $league=$row['league'];

    if(isset($court) && (strlen($court)>0)) {
      $court=" ($court)";
    }else{
      $court="";
    }

    $game_class="schedule-table__row";
    if($edited==1) {
      $game_class .= ' schedule-table__row--edited';
    }

    $ref_html = ($ref_name ? "($ref_name)" : "");
    print <<<EOF
<tr class="$game_class">
  <td>$dt</td>
  <td>$tm</td>
  <td>$home</td>
  <td>$visitor</td>
  <td><a href="/gyms.php?gym=$gymID">$gym</a> $ref_html</td>
  <td>$league</td>
</tr>
EOF;
  }

  mysqli_free_result($result);

  print <<<EOF
</table>
</div>
EOF;

}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

dbclose();

?>

<?php include("footer.html.php"); ?>
