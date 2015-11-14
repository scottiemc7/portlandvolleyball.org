<?php

include 'header.html';
include '../lib/mysql.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}


$req=array_merge($_GET,$_POST);

/*
   Pre-season tables: registration, registration_leagues, team_members
   Current season tables: teams (except missing manager info), leagues, ?
*/
$season="pre";
//$season="cur";

if(isset($req['id'])) {
  $id=preg_replace('/[^\d]/','',$req['id']);

  list($teamname,$league)=GetTeam($season,$id);

  print <<<EOF
<p />
<table>
  <tr><td align="right"><i><b>Team Name:</b></i></td><td>$teamname</td></tr>
  <tr><td align="right"><i><b>League:</b></i></td><td>$league</td></tr>
</table>
<p />
EOF;

  $submit=$req['submit'];
  if(strcasecmp($submit,"Modify roster")==0) {
    // Delete old roster and save new roster
    ModifyRoster($season,$id,$req);
    // Display new roster
    ShowRoster($season,$id);
  }elseif(strcasecmp($submit,"Show roster")==0) {
    // Display roster
    ShowRoster($season,$id);
  }else{
    // Display roster as a form for editing
    FormRoster($season,$id);
  }

}else{
  // Present team selection form
  FormTeams($season);
}

dbclose();

//include("footer.html");
exit;

/********************************************************/

/**
*** Replace existing roster (if any) with a new roster
**/

function ModifyRoster($season,$id,$req) {

  // Process modified roster
  $lname=array();
  $fname=array();
  $ssize=array();
  for($i=0; $i<12; $i++) {
    if(isset($req["lastname$i"])) {
      $lastname=CleanText($req["lastname$i"]);
      if(preg_match("/[a-zA-Z]/",$lastname)) {
        $firstname=CleanText($req["firstname$i"]);
        array_push($lname,$lastname);
        array_push($fname,$firstname);
        array_push($ssize,$req["shirtsize$i"]);
      }
    }
  }
      
  // Remove existing roster
  if(strcasecmp($season,"cur")==0) {
  }else{
    if(!dbquery("DELETE IGNORE FROM team_members WHERE teamid=$id")) {
      $error=dberror();
      print "***ERROR*** dbquery: Failed query<br />$error\n";
      exit;
    }
  }

  // Insert new roster
  for($i=0; $i<count($lname); $i++) {
    if(strcasecmp($season,"cur")==0) {
    }else{

      $sql=<<<EOF
INSERT INTO team_members 
(teamid,lastName,firstName,addedBy,dateAdded,shirtSize)
VALUES
($id,'$lname[$i]','$fname[$i]','Admin',now(),'$ssize[$i]')
EOF;

      if(!dbquery($sql)) {
        $error=dberror();
        print "***ERROR*** dbquery: Failed query<br />$error\n";
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
*** Clean user submitted text
**/

function CleanText($text) {
  // Replace nonprintable ASCII with spaces
  $text=preg_replace('/[\x00-\x1F\x7F-\xFF]/',' ',$text);
  // Replace double quotes with a single quote
  $text=preg_replace('/"/','\'',$text);
  // Replace multiple contiguous spaces with one space
  $text=preg_replace('/\s+/',' ',$text);
  // Remove leading and trailing spaces
  $text=trim($text);
  return $text;
}

/**
*** Display roster as a table
**/

function ShowRoster($season,$id) {
  print <<<EOF
<table>
  <tr><th>Name</th><th>Shirt Size</th><th> &nbsp; &nbsp; Added On</th><th>Added By</th></tr>
EOF;

  $roster=GetRoster($season,$id);
  foreach($roster as $member) {
    $lastName=$member['lastName'];
    $firstName=$member['firstName'];
    $shirtSize=$member['shirtSize'];
    $addedBy=$member['addedBy'];
    $dateAdded=$member['dateAdded'];

    print <<<EOF
  <tr><td>$lastName, $firstName</td><td align="center">$shirtSize</td><td>$dateAdded</td><td>$addedBy</td></tr>
EOF;
  }

  $script= $_SERVER['PHP_SELF'];
  print <<<EOF
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
*** Generate roster form
**/

function FormRoster($season,$id) {

  $shirtsizes = array('XSM','SM','M','L','XL','XXL');

  print <<<EOF
<p />
<form method="post">
<input type="hidden" name="id" value="$id"/>
<table>
<tr><th>Last Name</th><th>First Name</th><th>Shirt Size</th></tr>
EOF;

  $i=0;
  $roster=GetRoster($season,$id);
  foreach($roster as $member) {
    $lastName=$member['lastName'];
    $firstName=$member['firstName'];
    $shirtSize=$member['shirtSize'];
    $addedBy=$member['addedBy'];
    $dateAdded=$member['dateAdded'];

    print <<<EOF
<tr>
  <td><input type="text" name="lastname$i" value="$lastName" size="25" /></td>
  <td><input type="text" name="firstname$i" value="$firstName" size="25" /></td>
  <td><select name="shirtsize$i">
EOF;

    foreach ($shirtsizes as $ss) {
      $selected="";
      if(strcasecmp($shirtSize,$ss) == 0) {
        $selected='selected="selected"';
      }
      print <<<EOF
<option value="$ss"$selected>$ss</option>
EOF;
    }

    print <<<EOF
  </select></td>
</tr>
EOF;
    $i++;
  }

  for($j=$i; $j<12; $j++) {

    print <<<EOF
<tr>
  <td><input type="text" name="lastname$j" value="" size="25" /></td>
  <td><input type="text" name="firstname$j" value="" size="25" /></td>
  <td><select name="shirtsize$j">
EOF;

    foreach ($shirtsizes as $ss) {
      print <<<EOF
<option value="$ss">$ss</option>
EOF;
    }

    print <<<EOF
  </select></td>
</tr>
EOF;
  }

  print <<<EOF
</table>
<input type="submit" name="submit" value="Modify roster"/>
<input type="reset"/>
</form>
<p />
<a href="$script">Select another roster</a>
EOF;

}

/**
*** List available teams for selection
**/

function FormTeams($season) {

  // Lookup all teams
  if(strcasecmp($season,"cur")==0) {
    $sql=<<<EOF
SELECT t.id AS id, t.name AS team, league.name AS league
FROM teams t 
JOIN leagues league on t.league=league.id 
WHERE league.active=1
ORDER BY t.name
EOF;
  }else{
    $sql=<<<EOF
SELECT t.id AS id, t.teamName AS team, league.name AS league
FROM registration t 
JOIN registration_leagues league on t.league=league.id 
WHERE league.active=1
ORDER BY t.teamName
EOF;
  }

  if($result=dbquery($sql)) {

    print <<<EOF
<p />
Select team:
<form method="post">
  <select name="id">
EOF;

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $team=$row['team'];
      $league=$row['league'];

      print <<<EOF
<option value="$id">$team ($league)</option>
EOF;
    }

    print <<<EOF
  </select>
  <p />
  <input type="submit" name="submit" value="Show roster"/>
  <p />
</form>
EOF;

    mysqli_free_result($result);
  }else{
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }

}

/**
*** Get a team name and its league
**/

function GetTeam($season,$id) {

  $team="";
  $league="";

  if(strcasecmp($season,"cur")==0) {
    $sql=<<<EOF
SELECT t.name AS team, league.name AS league
FROM teams t 
JOIN leagues league on t.league = league.id 
WHERE t.id=$id
EOF;
  }else{
    $sql=<<<EOF
SELECT t.teamName AS team, league.name AS league
FROM registration t 
JOIN registration_leagues league on t.league = league.id 
WHERE t.id=$id
EOF;
  }
  //print_r($team);

  if($result=dbquery($sql)) {
    $row_cnt=mysqli_num_rows($result);
    if($row_cnt==0) {
      Error("No team found for teamID=$id");
    }else{
      $row=mysqli_fetch_assoc($result);
      $team=$row['team'];
      $league=$row['league'];
    }
    mysqli_free_result($result);
  }else{
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }

  return array($team,$league);
}

/**
*** Display error message
**/

function Error($txt) {
  print <<<EOF
<font color="#ff0000">ERROR:</font> $txt
<p />

EOF;
  exit;
}

/**
*** Get a roster
**/

function GetRoster($season,$id) {

  $roster=array();

  if(strcasecmp($season,"cur")==0) {
    $sql=<<<EOF
SELECT * FROM ? WHERE teamid=$id
EOF;
  }else{
    $sql=<<<EOF
SELECT lastName, firstName, shirtSize, addedBy, dateAdded
FROM team_members
WHERE teamid=$id
EOF;
  }

  if($result=dbquery($sql)) {
    while($row=mysqli_fetch_assoc($result)) {
      $roster[]=array(
        'lastName' => $row['lastName'],
        'firstName' => $row['firstName'],
        'shirtSize' => $row['shirtSize'],
        'addedBy' => $row['addedBy'],
        'dateAdded' => $row['dateAdded']
      );
    }
    mysqli_free_result($result);
  }else{
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }

  return $roster;
}

?>
