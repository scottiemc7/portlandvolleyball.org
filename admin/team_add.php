<?php

require_once '../lib/mysql.php';
include 'header.html.php';

print <<<EOF
<h1>Add new team</h1>
EOF;

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

if($_POST['delete'] == "yes") {
  $id=preg_replace('/[^\d]/','',$_POST['id']);
  if(! dbquery("DELETE FROM teams WHERE id=$id")) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}	
	
if($_POST['name'] != "") {
  $name=dbescape($_POST['name']);
  $league=preg_replace('/[^\d]/','',$_POST['league']);

  if(! dbquery("INSERT INTO teams (name,league) VALUES('$name',$league)")) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}

print <<<EOF
<p>Note: In order to add a team, the league must already be in the database.</p>
<form name="addTeam" class="eventForm" method="post">
	<table>
		<tr>
			<td><b>Team name:</b></td>
			<td><input type="text" name="name"></td>
		</tr>
		<tr>
			<td><b>League:</b></td>
			<td><select name="league">
				<option value=""> -- Select -- </option>
EOF;

$sql=<<<EOF
SELECT * FROM leagues WHERE active=1 ORDER BY name
EOF;

if($result=dbquery($sql)) {

  while($row=mysqli_fetch_assoc($result)) {
    $id=$row['id'];
    $name=$row['name'];

    print <<<EOF
<option value="$id">$name</option>
EOF;
  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

print <<<EOF
				</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" value="Add Team"></td>
		</tr>
	</table>
</form>

<h1>Current teams</h1>
<table cellpadding="6" cellspacing="0" width="750" class="eventTable">
	<tr>
		<th>Team Name</th>
		<th>League</th>
		<th>&nbsp;</th>
	</tr>
EOF;

$sql=<<<EOF
SELECT teams.id AS id, teams.name AS team, leagues.name AS league
FROM teams LEFT JOIN leagues ON leagues.id=teams.league 
ORDER BY leagues.name, teams.name
EOF;

if($result=dbquery($sql)) {

  while($row=mysqli_fetch_assoc($result)) {
    $id=$row['id'];
    $team=$row['team'];
    $league=$row['league'];

    print <<<EOF
	<tr>
		<td valign="top">$team</td>
		<td valign="top">$league</td>
		<td>
		<form action="team_edit.php" method="post">
			<input type="submit" value="Edit" />
			<input type="hidden" name="id" value="$id" />
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
</body>
</html>
EOF;

dbclose();
?>
