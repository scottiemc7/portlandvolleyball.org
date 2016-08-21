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
</table>
<p />
EOF;

    $submit = $req['submit'];
    if (strcasecmp($submit, 'Modify roster') == 0) {
        // Delete old roster and save new roster
    ModifyRoster($dbh, $season, $id, $req);
    // Display new roster
    ShowRoster($dbh, $season, $id);
    } elseif (strcasecmp($submit, 'Show roster') == 0) {
        // Display roster
    ShowRoster($dbh, $season, $id);
    } else {
        // Display roster as a form for editing
    FormRoster($dbh, $season, $id);
    }
} else {
    // Present team selection form
  FormTeams($dbh, $season);
}

include '../footer.html';
exit;

/********************************************************/

/**
 *** Replace existing roster (if any) with a new roster.
 **/
function ModifyRoster($dbh, $season, $id, $req)
{

  // Process modified roster
  $lname = array();
    $fname = array();
    $ssize = array();
    for ($i = 0; $i < 12; ++$i) {
        if (isset($req["lastname$i"])) {
            $lastname = CleanText($req["lastname$i"]);
            if (preg_match('/[a-zA-Z]/', $lastname)) {
                $firstname = CleanText($req["firstname$i"]);
                array_push($lname, $lastname);
                array_push($fname, $firstname);
                array_push($ssize, $req["shirtsize$i"]);
            }
        }
    }

  // Remove existing roster
  if (strcasecmp($season, 'cur') == 0) {
  } else {
      $sql = "DELETE IGNORE FROM team_members WHERE teamid=$id";
    //print "$sql<p />";
    $status = $dbh->query($sql);
      if (DB::isError($status)) {
          die($status->getMessage());
      }
  }

  // Insert new roster
  for ($i = 0; $i < count($lname); ++$i) {
      if (strcasecmp($season, 'cur') == 0) {
      } else {
          $sql = "INSERT INTO team_members
            (teamid,lastName,firstName,addedBy,dateAdded,shirtSize)
      VALUES
      ($id,'$lname[$i]','$fname[$i]','Admin',now(),'$ssize[$i]')";
      //print "$sql<p />";
      $status = $dbh->query($sql);
          if (DB::isError($status)) {
              die($status->getMessage());
          }
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
function ShowRoster($dbh, $season, $id)
{
    echo <<<'EOF'
<table>
  <tr><th>Name</th><th>Shirt Size</th><th> &nbsp; &nbsp; Added On</th><th>Added By</th></tr>
EOF;

    $qryMembers = GetRoster($dbh, $season, $id);
    foreach ($qryMembers as $members) {
        for ($i = 0; $i < 5; ++$i) {
            if (empty($members[$i])) {
                $members[$i] = '&nbsp;';
            }
        }
        echo <<<EOF
  <tr><td>$members[0], $members[1]</td><td align="center">$members[2]</td><td>$members[3]</td><td>$members[4]</td></tr>
EOF;
    }

    $script = $_SERVER['PHP_SELF'];
    echo <<<EOF
</table>
<p />
<form method="post">
<input type="hidden" name="id" value="$id"/>
<input type="submit" name="submit" value="Edit roster"/>
</form>
<p />
<a href="$script">Select another roster</a>
EOF;
}

/**
 *** Generate roster form.
 **/
function FormRoster($dbh, $season, $id)
{
    $shirtsizes = array('XSM', 'SM', 'M', 'L', 'XL', 'XXL');

    echo <<<EOF
<form method="post">
<input type="hidden" name="id" value="$id"/>
<table>
<tr><th>Last Name</th><th>First Name</th><th>Shirt Size</th></tr>
EOF;

    $i = 0;
    $qryMembers = GetRoster($dbh, $season, $id);
    foreach ($qryMembers as $members) {
        $lastname = $req['lastname'.$i];
        $firstname = $req['firstname'.$i];
        $shirtsize = $req['shirtsize'.$i];

        echo <<<EOF
<tr>
  <td><input type="text" name="lastname$i" value="$members[0]" size="25" /></td>
  <td><input type="text" name="firstname$i" value="$members[1]" size="25" /></td>
  <td><select name="shirtsize$i">
EOF;

        foreach ($shirtsizes as $ss) {
            $selected = '';
            if (strcasecmp($members[2], $ss) == 0) {
                $selected = 'selected="selected"';
            }
            echo <<<EOF
<option value="$ss"$selected>$ss</option>
EOF;
        }

        echo <<<'EOF'
  </select></td>
</tr>
EOF;
        ++$i;
    }

    for ($j = $i; $j < 12; ++$j) {
        echo <<<EOF
<tr>
  <td><input type="text" name="lastname$j" value="" size="25" /></td>
  <td><input type="text" name="firstname$j" value="" size="25" /></td>
  <td><select name="shirtsize$j">
EOF;

        foreach ($shirtsizes as $ss) {
            echo <<<EOF
<option value="$ss">$ss</option>
EOF;
        }

        echo <<<'EOF'
  </select></td>
</tr>
EOF;
    }

    echo <<<EOF
</table>
<input type="submit" name="submit" value="Modify roster"/>
<input type="reset"/>
</form>
<p />
<a href="$script">Select another roster</a>
EOF;
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
