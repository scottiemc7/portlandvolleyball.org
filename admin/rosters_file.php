<?php

include '/home/pva/portlandvolleyball.org/lib/mysql.php';

session_start();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
  // Already logged in
}else{
  // Must be logged in first
  header("Location: login.php");
  exit;
}

$contents="Id\tTeam\tLeague\tPlayer\tShirt Size\tDate Added\tAdded By\n";

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

$sql=<<<EOF
SELECT t.id AS id, t.teamName AS team, league.name AS league
FROM registration t 
JOIN registration_leagues league ON t.league=league.id 
WHERE league.active=1
ORDER BY t.teamName
EOF;

if($result=dbquery($sql)) {

  while($row=mysqli_fetch_assoc($result)) {
    $id=$row['id'];
    $team=$row['team'];
    $league=$row['league'];

    $sql=<<<EOF
SELECT lastName, firstName, shirtSize, dateAdded, addedBy
FROM team_members WHERE teamid=$id ORDER BY lastName,firstName
EOF;
    if($result2=dbquery($sql)) {
      while($row=mysqli_fetch_assoc($result2)) {
        $lastName=$row['lastName'];
        $firstName=$row['firstName'];
        $shirtSize=$row['shirtSize'];
        $dateAdded=$row['dateAdded'];
        $addedBy=$row['addedBy'];

	$contents.="$id\t$team\t$league\t$lastName, $firstName\t$shirtSize\t$dateAdded\t$addedBy\n";
      }
      mysqli_free_result($result2);
    }else{
      $error=dberror();
      print "***ERROR*** dbquery: Failed query<br />$error\n";
      exit;
    }
  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

dbclose();

header("Content-type: application/octet-stream");
header("Content-disposition: attachment; filename=rosters.csv");
print $contents; 
