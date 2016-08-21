<?php

include '../header.html';

// Connect to database
require 'DB.php';
$dsn = 'mysql://pvaDBusr:V0ll3y@mysql.portlandvolleyball.org/pvaDB';
$dbh = DB::connect($dsn);
if (DB::isError($dbh)) {
    die($dbh->getMessage());
}

$req = array_merge($_GET, $_POST);

/*
   Pre-season tables: registration, registration_leagues, team_members
   Current season tables: teams (except missing manager info), leagues, ?
*/
$season = 'pre';
//$season="cur";

if (isset($req['id'])) {
    $id = $req['id'];
    list($teamname, $league) = GetTeam($dbh, $season, $id);

    echo <<<EOF
<table>
  <tr><td align="right"><i><b>Team Name:</b></i></td><td>$teamname</td></tr>
  <tr><td align="right"><i><b>League:</b></i></td><td>$league</td></tr>
  <tr><td align="right" valign="top"><i><b>Team Members:</b></i></td><td>
EOF;

  // Display roster
  ShowRoster($dbh, $season, $id);

    $script = $_SERVER['PHP_SELF'];
    echo <<<EOF
  </td></tr>
</table>
<p />
<a href="$script">Select another roster</a>
<p />
<i>
To make changes to a roster, the team manager must send an email to
<a href="mailto:info@portlandvolleyball.org">info@portlandvolleyball.org</a>
containing the following required information:
<ul>
<li>To add a new team member, the email must contain:
  <ol>
  <li>Action: ADD A NEW TEAM MEMBER</li>
  <li>Team Name: </li>
  <li>Team Manager's Name:</li>
  <li>League: (e.g. COED A)</li>
  <li>League Night: (e.g. WEDNESDAY)</li>
  <li>First Name of New Team Member:</li>
  <li>Last Name of New Team Member:</li>
  <li>Shirt Size of New Team Member: (e.g. XSM, SM, M, L, XL, or XXL)</li>
  </ol>
</li>
<li>To remove a team member, the email must contain:
  <ol>
  <li>Action: REMOVE A TEAM MEMBER</li>
  <li>Team Name: </li>
  <li>Team Manager's Name:</li>
  <li>League: (e.g. COED A)</li>
  <li>League Night: (e.g. WEDNESDAY)</li>
  <li>First Name of Team Member:</li>
  <li>Last Name of Team Member:</li>
  </ol>
</li>
<li>To modify a team member's information, the email must contain:
  <ol>
  <li>Action: MODIFY A TEAM MEMBER</li>
  <li>Team Name: </li>
  <li>Team Manager's Name:</li>
  <li>League: (e.g. COED A)</li>
  <li>League Night: (e.g. WEDNESDAY)</li>
  <li>Original First Name of Team Member:</li>
  <li>Original Last Name of Team Member:</li>
  <li>New First Name of Team Member:</li>
  <li>New Last Name of Team Member:</li>
  <li>Shirt Size of Team Member: (e.g. XSM, SM, M, L, XL, or XXL)</li>
  </ol>
</li>
</ul>
</i>
EOF;
} else {
    // Present team selection form
  FormTeams($dbh, $season);
}

include '../footer.html';
exit;

/********************************************************/

/**
 *** Display roster.
 **/
function ShowRoster($dbh, $season, $id)
{
    $qryMembers = GetRoster($dbh, $season, $id);
    foreach ($qryMembers as $members) {
        // Only use first character of last name
    $lastname = substr($members[0], 0, 1);
        $firstname = $members[1];
        $fullname = "$firstname $lastname.";
        if (strlen($fullname) > 2) {
            echo <<<EOF
$fullname<br />
EOF;
        }
    }
}

/**
 *** List available teams for selection.
 **/
function FormTeams($dbh, $season)
{

  // Lookup all teams
  if (strcasecmp($season, 'cur') == 0) {
      $qryTeams = $dbh->getAll('SELECT t.id, t.name, league.name
                              FROM teams t
                              JOIN leagues league on t.league = league.id
                              WHERE league.active = 1
                              ORDER BY t.name');
  } else {
      $qryTeams = $dbh->getAll('SELECT t.id, t.teamName, league.name
                              FROM registration t
                              JOIN registration_leagues league on t.league = league.id
                              WHERE league.active = 1
                              ORDER BY t.teamName');
  }

    echo <<<'END'
Select team:
<form method="post">
  <select name="id">
END;

    foreach ($qryTeams as $team) {
        echo <<<END
<option value="$team[0]">$team[1] ($team[2])</option>
END;
    }

    echo <<<'END'
  </select>
  <p />
  <input type="submit" name="submit" value="Show roster"/>
  <p />
</form>
END;
}

/**
 *** Get a team name and its league.
 **/
function GetTeam($dbh, $season, $id)
{
    if (strcasecmp($season, 'cur') == 0) {
        $team = $dbh->getAll("SELECT t.name, league.name
                        FROM teams t
                        JOIN leagues league on t.league = league.id
                        WHERE t.id=$id");
    } else {
        $team = $dbh->getAll("SELECT t.teamName, league.name
                        FROM registration t
                        JOIN registration_leagues league on t.league = league.id
                        WHERE t.id=$id");
    }
  //print_r($team);

  $cnt = count($team);
    if ($cnt < 1) {
        Error("No team found for teamID=$id");
    } elseif ($cnt > 1) {
        Error("More than one team found for teamID=$id");
    }

    return array($team[0][0], $team[0][1]);
}

/**
 *** Display error message.
 **/
function Error($txt)
{
    echo <<<EOF
<font color="#ff0000">ERROR:</font> $txt
<p />

EOF;
    exit;
}

/**
 *** Get a roster.
 **/
function GetRoster($dbh, $season, $id)
{
    if (strcasecmp($season, 'cur') == 0) {
        $qryMembers = $dbh->getAll("SELECT *
                  FROM ?
                              WHERE teamid=$id");
    } else {
        $qryMembers = $dbh->getAll("SELECT lastName, firstName, shirtSize, dateAdded, addedBy
                  FROM team_members
                              WHERE teamid=$id");
    }

    return $qryMembers;
}
