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

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

$sql=<<<EOF
SELECT * FROM registration_leagues
EOF;

$leagues=array();
if($result=dbquery($sql)) {

  while($row=mysqli_fetch_assoc($result)) {
    $id=$row['id'];
    $name=$row['name'];
    $night=$row['night'];
    $active=$row['active'];

    $leagues[$id]['name']=$name;
    $leagues[$id]['night']=$night;
    $leagues[$id]['active']=$active;
  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

$sql=<<<EOF
SELECT id, teamName, mgrName, mgrPhone, mgrEmail, paid, league, league2,
(SELECT COUNT(*) FROM team_members WHERE teamid=id) AS teamcount,
addr1, city, state, zip
FROM registration
EOF;

if($result=dbquery($sql)) {

  $contents="";
  $row_cnt=mysqli_num_rows($result);
  if($row_cnt > 0) {

    $contents="Team Name\tPaid\tRoster\tLeague\t2nd Choice League\tManager\tPhone\tEmail\tAddress\n";

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $teamName=$row['teamName'];
      $mgrName=$row['mgrName'];
      $mgrPhone=$row['mgrPhone'];
      $mgrEmail=$row['mgrEmail'];
      $paid=$row['paid'];
      $league=$row['league'];
      $league2=$row['league2'];
      $teamcount=$row['teamcount'];
      $addr1=$row['addr1'];
      $city=$row['city'];
      $state=$row['state'];
      $zip=$row['zip'];

      $paid = $paid ? "Paid" : "Not paid";
      $roster = ($teamcount < 1) ? "No" : $teamcount . " players";

      $l1="????";
      if(isset($leagues[$league])) {
        $l1=$leagues[$league]['name'] . " " . $leagues[$league]['night'];
      }
      $l2="????";
      if(isset($leagues[$league2])) {
        $l2=$leagues[$league2]['name'] . " " . $leagues[$league2]['night'];
      }

$address="$addr1, $city, $state $zip";

      $contents.=<<<EOF
$teamName\t$paid\t$roster\t$l1\t$l2\t$mgrName\t$mgrPhone\t$mgrEmail\t$address

EOF;

    }
  }else{
    $contents="There are no items to display.\n";
  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

dbclose();

header("Content-type: application/octet-stream");
header("Content-disposition: attachment; filename=registrations.csv");
print $contents; 
