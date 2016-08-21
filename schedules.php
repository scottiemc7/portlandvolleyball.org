<?php include 'header.html'; ?>

<?php
include 'lib/mysql.php';

$error = dbinit();
if ($error !== '') {
    echo "***ERROR*** dbinit: $error\n";
    exit;
}

/*
SELECT t.id, t.name, league.name
FROM teams t
JOIN leagues league ON t.league=league.id WHERE league.active=1
ORDER BY t.name
*/
$sql = <<<'EOF'
SELECT t.id AS id, t.name AS team, l.name AS league
FROM teams t, leagues l
WHERE t.league=l.id
AND l.active=1
ORDER BY t.name
EOF;

if (!$qryTeams = dbquery($sql)) {
    $error = dberror();
    echo "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
}

$sql = <<<'EOF'
SELECT * FROM leagues WHERE active=1 ORDER BY name
EOF;

if (!$qryLeagues = dbquery($sql)) {
    $error = dberror();
    echo "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
}

echo <<<'EOF'
<div id="content">
  <div style="width: 980px;">
  <h1>Schedules</h1>
    <div style="float: left; width: 450px;">
    <p>
      To sort, choose one of the options below, and click "Sort".
      <br>
      Games that have been changed are denoted with a <span style="background-color: #ffff99;">yellow background</span>.
    </p>

    <p>
      For scheduling questions, contact Michelle Baldwin at
      <script language="javascript">
      document.write('<a href="mailto:' + getE('info', 'portlandvolleyball.org') + '">' + getE('info', 'portlandvolleyball.org') + '</a>.</p>');
    </script>
    </div>
    <div style="float: right; width: 500px; background-color: #ffffcc; padding: 10px 10px 0px 10px; border: 1px solid #0066cc;">
    <b>Sign up for our mailing list</b>
    <p>
      <form method="post" action="http://scripts.dreamhost.com/add_list.cgi">
      <input type="hidden" name="list" value="announcements@portlandvolleyball.org" />
      <input type="hidden" name="domain" value="portlandvolleyball.org" />
      <input type="hidden" name="emailit" value="0" />
      Name: <input name="name" /> &nbsp; E-mail: <input name="email" /> <input type="submit" name="submit" value="Sign up" />
      </form>
    </div>
  </div>
<form name="sort" method="post" style="clear: both;">
  <select name="teams" onchange="document.sort.leagues.selectedIndex = 0;">
  <option value="">-- Select team --</option>
EOF;

while ($row = mysqli_fetch_assoc($qryTeams)) {
    $id = $row['id'];
    $name = $row['team'];
    $league = $row['league'];
    echo <<<EOF
<option value="$id">$name ($league)</option>
EOF;
}

mysqli_free_result($qryTeams);

echo <<<'EOF'
  </select>

  <select name="leagues" onchange="document.sort.teams.selectedIndex = 0;">
  <option value="">-- Select league --</option>
EOF;

while ($row = mysqli_fetch_assoc($qryLeagues)) {
    $id = $row['id'];
    $name = $row['name'];
    echo <<<EOF
<option value="$id">$name</option>
EOF;
}

mysqli_free_result($qryLeagues);

echo <<<'EOF'
  </select>

  <input type="submit" value="sort"/>
</form>

<table class="interiorTable" cellspacing="0">
  <tr>
    <th>Date</th>
    <th>Time</th>
    <th>Home</th>
    <th>Visitor</th>
    <th>Location</th>
    <th>League</th>
  </tr>
EOF;

$leagues = $_POST['leagues'];
$teams = $_POST['teams'];
$where = 'where dt >= curdate()';

if (isset($leagues) && ($leagues > 0)) {
    $where .= " AND (home.league=$leagues OR visitor.league=$leagues)";
}

if (isset($teams) && ($teams > 0)) {
    $where .= " AND (home.id=$teams OR visitor.id=$teams)";
}

$sql = <<<EOF
SELECT DATE_FORMAT(dt, '%c/%d (%a)') as dt, tm, home.name AS h, visitor.name AS v, gym.id AS gymID, gym.name AS gymName, court, edited, l.name AS league
FROM games g
JOIN teams home on g.home = home.id
JOIN teams visitor on g.visitor = visitor.id
JOIN gyms gym on gym.id = g.gym
JOIN leagues l on l.id = home.league
$where
ORDER BY g.dt, g.tm
EOF;

if ($result = dbquery($sql)) {
    $row_cnt = mysqli_num_rows($result);

    while ($row = mysqli_fetch_assoc($result)) {
        $dt = $row['dt'];
        $tm = $row['tm'];
        $home = stripslashes($row['h']);
        $visitor = stripslashes($row['v']);
        $gymID = $row['gymID'];
        $gym = $row['gymName'];
        $court = $row['court'];
        $edited = $row['edited'];
        $league = $row['league'];

        if (isset($court) && (strlen($court) > 0)) {
            $court = " ($court)";
        } else {
            $court = '';
        }

        $rowstyle = '';
        if ($edited == 1) {
            $rowstyle = ' bgcolor="#ffff99"';
        }

        echo <<<EOF
<tr$rowstyle>
  <td>$dt</td>
  <td>$tm</td>
  <td>$home</td>
  <td>$visitor</td>
  <td><a href="/gyms.php?gym=$gymID">$gym</a> $court</td>
  <td>$league</td>
</tr>
EOF;
    }

    mysqli_free_result($result);

    echo <<<'EOF'
</table>
</div>
EOF;
} else {
    $error = dberror();
    echo "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
}

dbclose();

?>

<?php include 'footer.html'; ?>
