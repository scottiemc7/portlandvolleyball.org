<?php

/****************************************************************/
// $gyms=getGyms();
date_default_timezone_set('America/Los_Angeles');

function getGyms() {

  $gyms=array();

  $sql=<<<EOF
SELECT * FROM gyms ORDER BY name
EOF;

  if($result=dbquery($sql)) {

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $name=$row['name'];
      $address=$row['address'];
      $map=$row['map'];
      $directions=$row['directions'];

      $gyms[$name]['id']=$id;
      $gyms[$name]['address']=$address;
      $gyms[$name]['map']=$map;
      $gyms[$name]['directions']=$directions;
    }

    mysqli_free_result($result);
  }else{
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }

  return($gyms);
}

/****************************************************************/
// $leagues=getLeagues($active);

function getLeagues($active=-1) {

  $leagues=array();

  $where="";
  if(isset($active) && is_numeric($active)) {
    if($active==1) {
      $where="WHERE active=1";
    }elseif($active==0) {
      $where="WHERE active=0";
    }
  }

  $sql="SELECT * FROM leagues $where ORDER BY name";

  if($result=dbquery($sql)) {

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $name=$row['name'];

      $leagues[$name]['id']=$id;
      $leagues[$name]['active']=$active;
    }

    mysqli_free_result($result);
  }else{
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }

  return($leagues);
}

/****************************************************************/
// $value=getOne($name);

function getOne($name) {
  if($result=dbquery("SELECT value FROM vars WHERE name='$name'")) {
    if($row=mysqli_fetch_assoc($result)) {
      return $row['value'];
    }else{
      print "***ERROR*** dbquery: No value for $name\n";
      exit;
    }
    mysqli_free_result($result);
  }else{
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}

/****************************************************************/
// $refs=getRefs();

function getRefs() {

  $refs=array();

  $sql=<<<EOF
SELECT * FROM refs ORDER BY lname,fname
EOF;

  if($result=dbquery($sql)) {

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $uname=$row['uname'];
      $password=$row['password'];
      $fname=$row['fname'];
      $lname=$row['lname'];

      $ref="$lname, $fname";
      $refs[$ref]['id']=$id;
      $refs[$ref]['uname']=$uname;
      $refs[$ref]['password']=$password;
    }

    mysqli_free_result($result);
  }else{
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }

  return($refs);
}

/****************************************************************/
// $teams=getTeams();

function getTeams() {

  $teams=array();

  $sql=<<<EOF
SELECT t.id AS id, t.name AS team, l.name AS league
FROM (teams t LEFT JOIN leagues l ON l.id=t.league)
ORDER BY t.name
EOF;

  if($result=dbquery($sql)) {

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $team=$row['team'];
      $league=$row['league'];

      $teams[$team]['id']=$id;
      $teams[$team]['league']=$league;
    }

    mysqli_free_result($result);
  }else{
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }

  return($teams);
}

/****************************************************************/
// setOne($name,$value);

function setOne($name,$value) {
  $name=preg_replace('/[^a-zA-Z\_]/','',$name);
  $value=preg_replace('/[^a-zA-Z0-9\.\,\/\ ]/','',$value);
  if(!dbquery("UPDATE vars SET value='$value' WHERE name='$name'")) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}

/****************************************************************/

?>
