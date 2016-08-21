<?php

include 'header.html';
include '../lib/mysql.php';

$error = dbinit();
if ($error !== '') {
    echo "***ERROR*** dbinit: $error\n";
    exit;
}

$req = array_merge($_GET, $_POST);

/*
   Pre-season tables: registration, leagues, team_members
   Current season tables: teams (except missing manager info), leagues, ?
*/
$season = 'pre';
//$season="cur";

if (isset($req['id'])) {
    $id = preg_replace('/[^\d]/', '', $req['id']);

    list($teamname, $league) = GetTeam($season, $id);

    echo <<<EOF
<p />
<table>
  <tr><td align="right"><i><b>Team Name:</b></i></td><td>$teamname</td></tr>
  <tr><td align="right"><i><b>League:</b></i></td><td>$league</td></tr>
</table>
<p />
EOF;

    $submit = $req['submit'];
    if (strcasecmp($submit, 'Modify Roster') == 0) {
        // Delete old roster and save new roster
    ModifyRoster($season, $id, $req);
    // Display new roster
    ShowRoster($season, $id);
    } elseif (strcasecmp($submit, 'Show Roster') == 0) {
        // Display roster
    ShowRoster($season, $id);
    } else {
        // Display roster as a form for editing
    FormRoster($season, $id);
    }
} else {
    // Present team selection form
  FormTeams($season);
}

dbclose();

//include("footer.html");
exit;

/********************************************************/

/**
 *** Replace existing roster (if any) with a new roster.
 **/
function ModifyRoster($season, $id, $req)
{

  // Process modified roster
  $lastNames = array();
    $firstNames = array();
    $emails = array();
    for ($i = 0; $i < 12; ++$i) {
        if (isset($req["lastname$i"])) {
            $lastname = CleanText($req["lastname$i"]);
            if (preg_match('/[a-zA-Z]/', $lastname)) {
                $firstname = CleanText($req["firstname$i"]);
                $email = CleanText($req["email$i"]);
                array_push($lastNames, $lastname);
                array_push($firstNames, $firstname);
                array_push($emails, $email);
            }
        }
    }

  // Remove existing roster
  if (strcasecmp($season, 'cur') == 0) {
  } else {
      if (!dbquery("DELETE IGNORE FROM team_members WHERE teamid=$id")) {
          $error = dberror();
          echo "***ERROR*** dbquery: Failed query<br />$error\n";
          exit;
      }
  }

  // Insert new roster
  for ($i = 0; $i < count($lastNames); ++$i) {
      if (strcasecmp($season, 'cur') == 0) {
      } else {
          $sql = <<<EOF
INSERT INTO team_members
(teamid,lastName,firstName,addedBy,dateAdded,email)
VALUES
($id,'$lastNames[$i]','$firstNames[$i]','Admin',now(),'$emails[$i]')
EOF;

          if (!dbquery($sql)) {
              $error = dberror();
              echo "***ERROR*** dbquery: Failed query<br />$error\n";
              exit;
          }
      //print "$sql<p />";
      }

    /*
    print <<<EOF
$i) $lname[$i], $fname[$i] : $ssize[$i]<br />
EOF;
    */
  }
}

/**
 *** Clean user submitted text.
 **/
function CleanText($text)
{
    // Replace nonprintable ASCII with spaces
  $text = preg_replace('/[\x00-\x1F\x7F-\xFF]/', ' ', $text);
  // Replace double quotes with a single quote
  $text = preg_replace('/"/', '\'', $text);
  // Replace multiple contiguous spaces with one space
  $text = preg_replace('/\s+/', ' ', $text);
  // Remove leading and trailing spaces
  $text = trim($text);

    return $text;
}

/**
 *** Display roster as a table.
 **/
function ShowRoster($season, $id)
{
    echo <<<'EOF'
<table class="roster-show">
  <tr><th>Name</th><th>Email Address</th><th> &nbsp; &nbsp; Added On</th><th>Added By</th></tr>
EOF;

    $roster = GetRoster($season, $id);
    foreach ($roster as $member) {
        $firstName = $member['firstName'];
        $lastName = $member['lastName'];
        $email = $member['email'];
        $addedBy = $member['addedBy'];
        $dateAdded = $member['dateAdded'];

        echo <<<EOF
  <tr><td>$firstName $lastName</td><td>$email</td><td>$dateAdded</td><td>$addedBy</td></tr>
EOF;
    }

    $script = $_SERVER['PHP_SELF'];
    echo <<<EOF
</table>
<p />
<form method="post">
<input type="hidden" name="id" value="$id"/>
<input type="submit" name="submit" value="Edit Roster"/>
</form>
<p />
<a href="$script">Select another roster</a>
EOF;
}

/**
 *** Generate roster form.
 **/
function FormRoster($season, $id)
{
    echo <<<EOF
<p />
<form method="post">
<input type="hidden" name="id" value="$id"/>
<table>
<tr><th>First Name</th><th>Last Name</th><th>Email Address</th></tr>
EOF;

    $i = 0;
    $roster = GetRoster($season, $id);
    foreach ($roster as $member) {
        $firstName = $member['firstName'];
        $lastName = $member['lastName'];
        $email = $member['email'];
        $addedBy = $member['addedBy'];
        $dateAdded = $member['dateAdded'];

        echo <<<EOF
<tr>
  <td><input type="text" name="firstname$i" value="$firstName" size="25" /></td>
  <td><input type="text" name="lastname$i" value="$lastName" size="25" /></td>
  <td><input type="text" name="email$i" value="$email" size="25" /></td>
</tr>
EOF;
        ++$i;
    }

    for ($j = $i; $j < 12; ++$j) {
        echo <<<EOF
<tr>
  <td><input type="text" name="firstname$j" value="" size="25" /></td>
  <td><input type="text" name="lastname$j" value="" size="25" /></td>
  <td><input type="text" name="email$j" value="" size="25" /></td>
</tr>
EOF;
    }

    $script = $_SERVER['PHP_SELF'];

    echo <<<EOF
</table>
<input type="submit" name="submit" value="Modify Roster"/>
<input type="reset"/>
</form>
<p />
<a href="$script">Select another roster</a>
EOF;
}

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
JOIN leagues league on t.league=league.id
WHERE league.active=1
ORDER BY t.name
EOF;
  } else {
      $sql = <<<'EOF'
SELECT t.id AS id, t.teamName AS team, league.name AS league
FROM registration t
JOIN leagues league on t.league=league.id
WHERE league.active=1
ORDER BY t.teamName
EOF;
  }

    if ($result = dbquery($sql)) {
        echo <<<'EOF'
<p />
Select team:
<form method="post">
  <select name="id">
EOF;

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $team = $row['team'];
            $league = $row['league'];

            echo <<<EOF
<option value="$id">$team ($league)</option>
EOF;
        }

        echo <<<'EOF'
  </select>
  <p />
  <input type="submit" name="submit" value="Show Roster"/>
  <p />
</form>
EOF;

        mysqli_free_result($result);
    } else {
        $error = dberror();
        echo "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
    }
}

/**
 *** Get a team name and its league.
 **/
function GetTeam($season, $id)
{
    $team = '';
    $league = '';

    if (strcasecmp($season, 'cur') == 0) {
        $sql = <<<EOF
SELECT t.name AS team, league.name AS league
FROM teams t
JOIN leagues league on t.league = league.id
WHERE t.id=$id
EOF;
    } else {
        $sql = <<<EOF
SELECT t.teamName AS team, league.name AS league
FROM registration t
JOIN leagues league on t.league = league.id
WHERE t.id=$id
EOF;
    }
  //print_r($team);

  if ($result = dbquery($sql)) {
      $row_cnt = mysqli_num_rows($result);
      if ($row_cnt == 0) {
          Error("No team found for teamID=$id");
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
    $roster = array();

    $sql = <<<EOF
SELECT lastName, firstName, email, addedBy, dateAdded
FROM team_members
WHERE teamid=$id
EOF;

    if ($result = dbquery($sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $roster[] = array(
        'lastName' => $row['lastName'],
        'firstName' => $row['firstName'],
        'email' => $row['email'],
        'addedBy' => $row['addedBy'],
        'dateAdded' => $row['dateAdded'],
      );
        }
        mysqli_free_result($result);
    } else {
        $error = dberror();
        echo "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
    }

    return $roster;
}
