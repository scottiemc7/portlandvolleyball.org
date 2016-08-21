<?php

include 'header.html';
include 'lib/mysql.php';

$req = array_merge($_GET, $_POST);

$error = dbinit();
if ($error !== '') {
    echo "***ERROR*** dbinit: $error\n";
    exit;
}

/*
      Pre-season tables: registration, registration_leagues, team_members
(New) Current season tables: registration2, registration_leagues2, team_members2
                 (empty tables and do a "data only" copy from Pre-season tables)

(Old) Current season tables: teams (except missing manager info), leagues, ?
*/
$season = 'pre';
//$season="cur";

if (isset($req['id'])) {
    $id = preg_replace('/[^\d]/', '', $req['id']);
    list($teamname, $league) = GetTeam($season, $id);

    echo <<<EOF
<table>
  <tr><td align="right"><i><b>Team Name:</b></i></td><td>$teamname</td></tr>
  <tr><td align="right"><i><b>League:</b></i></td><td>$league</td></tr>
  <tr><td align="right" valign="top"><i><b>Team Members:</b></i></td><td>
EOF;

  // Display roster
  GetRoster($season, $id);

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
  FormTeams($season);
}

dbclose();

include 'footer.html';
exit;

/********************************************************/

/**
 *** List available teams for selection.
 **/
function FormTeams($season)
{

  // Lookup all teams
  if (strcasecmp($season, 'cur') == 0) {
      $sql = <<<'EOF'
SELECT t.id AS id, t.name AS team, league.name AS league
FROM teams t 
JOIN leagues league on t.league = league.id 
WHERE league.active = 1
ORDER BY t.name
EOF;
  } else {
      //FROM registration2 t
//JOIN registration_leagues2 league on t.league = league.id
    $sql = <<<'EOF'
SELECT t.id AS id, t.teamName AS team, league.name AS league
FROM registration t 
JOIN registration_leagues league on t.league = league.id 
WHERE league.active = 1
ORDER BY t.teamName
EOF;
  }

    echo <<<'END'
Select team:
<form method="post">
  <select name="id">
END;

    if ($result = dbquery($sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $team = $row['team'];
            $league = $row['league'];

            echo <<<END
  <option value="$id">$team ($league)</option>
END;
        }

        mysqli_free_result($result);
    } else {
        $error = dberror();
        echo "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
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
function GetTeam($season, $id)
{
    $team = $league = '';

    if (strcasecmp($season, 'cur') == 0) {
        $sql = <<<EOF
SELECT t.name AS team, league.name AS league
FROM teams t 
JOIN leagues league on t.league = league.id 
WHERE t.id=$id
EOF;
    } else {
        //FROM registration2 t
//JOIN registration_leagues2 league on t.league = league.id
    $sql = <<<EOF
SELECT t.teamName AS team, league.name AS league
FROM registration t 
JOIN registration_leagues league on t.league = league.id 
WHERE t.id=$id
EOF;
    }

    if ($result = dbquery($sql)) {
        $cnt = mysqli_num_rows($result);
        if ($cnt < 1) {
            Error("No team found for teamID=$id");
        } elseif ($cnt > 1) {
            Error("More than one team found for teamID=$id");
        } else {
            $row = mysqli_fetch_assoc($result);
            $team = $row['team'];
            $league = $row['league'];
        }

        mysqli_free_result($result);
    } else {
        $error = dberror();
        echo "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
    }

    return array($team, $league);
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
function GetRoster($season, $id)
{
    if (strcasecmp($season, 'cur') == 0) {
        $sql = <<<EOF
SELECT *
FROM ?
WHERE teamid=$id
EOF;
    } else {
        //FROM team_members2
    $sql = <<<EOF
SELECT lastName, firstName, shirtSize, dateAdded, addedBy
FROM team_members
WHERE teamid=$id
EOF;
    }

    if ($result = dbquery($sql)) {
        $cnt = mysqli_num_rows($result);
        if ($cnt == 0) {
            echo <<<'EOF'
(No roster submitted)<p />
EOF;
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                $lastName = $row['lastName'];
                $firstName = $row['firstName'];
                $shirtSize = $row['shirtSize'];
                $dateAdded = $row['dateAdded'];
                $addedBy = $row['addedBy'];

        // Only use first character of last name
        $lastname = substr($lastName, 0, 1);
                $firstname = $firstName;
                $fullname = "$firstname $lastname.";
                if (strlen($fullname) > 2) {
                    echo <<<EOF
$fullname<br />
EOF;
                }
            }
        }

        mysqli_free_result($result);
    } else {
        $error = dberror();
        echo "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
    }
}
