
<?php

include("header.html");
include '../lib/mysql.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

$id=preg_replace('/[^\d]/','',$_GET['id']);

if(isset($_POST['league'])) {
  $leagueid=preg_replace('/[^\d]/','',$_POST['league']);
  if(is_numeric($leagueid)) {
    if(! dbquery("UPDATE registration SET league=$leagueid WHERE id=$id")) {
      $error=dberror();
      print "***ERROR*** dbquery: Failed query<br />$error\n";
      exit;
    }
  }
}

$sql=<<<EOF
SELECT r.id AS id, teamname, rl.name AS league1, rl.night AS night1, mgrName, mgrPhone, mgrPhone2, mgrEmail, mgrEmail2,
addr1, addr2, city, state, zip, altName, altPhone, altEmail, comments, rl2.name AS league2, rl2.night AS night2, newOld
FROM ((registration r LEFT JOIN leagues rl on rl.id = r.league) LEFT JOIN leagues rl2 on rl2.id = r.league2)
WHERE r.id = $id
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  if($row_cnt==0) {
    print "div style=\"width: 750px; font-weight: bold; text-align: center;\">There are no items to display.</div>";
  }else{

    print <<<EOF
<h1>Team Details</h1>

<form method="post">
Change league to:
<select name="league">
  <option value="">-- Select --</option>
EOF;

    getLeagues();

    print <<<EOF
</select>
<input type="submit" value="Change" />
</form>
<br/>
<br/>
EOF;

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $teamname=$row['teamname'];
      $league1=$row['league1'];
      $night1=$row['night1'];
      $mgrName=$row['mgrName'];
      $mgrPhone=$row['mgrPhone'];
      $mgrPhone2=$row['mgrPhone2'];
      $mgrEmail=$row['mgrEmail'];
      $mgrEmail2=$row['mgrEmail2'];
      $addr1=$row['addr1'];
      $addr2=$row['addr2'];
      $city=$row['city'];
      $state=$row['state'];
      $zip=$row['zip'];
      $altName=$row['altName'];
      $altPhone=$row['altPhone'];
      $altEmail=$row['altEmail'];
      $comments=$row['comments'];
      $league2=$row['league2'];
      $night2=$row['night2'];
      $newOld=$row['newOld'];

      print <<<EOF
<table border="1" cellspacing="0" cellpadding="3">
  <tr><td>Team name:</td><td>$teamname</td></tr>
  <tr><td>League:</td><td>$league1 - $night1</td></tr>
  <tr><td>2nd choice:</td><td>$league2 - $night2</td></tr>
  <tr><td>Manager:</td><td>$mgrName</td></tr>
  <tr><td>Phone:</td><td>$mgrPhone, $mgrPhone2</td></tr>
  <tr><td>Email:</td><td>$mgrEmail, $mgrEmail2</td></tr>
  <tr><td valign=\"top\">Address:</td><td>$addr1<br />$addr2<br />$city, $state  &nbsp;$zip</td></tr>
  <tr><td>Alternate contact:</td><td>$altName&nbsp;</td></tr>
  <tr><td>Alternate phone:</td><td>$altPhone&nbsp;</td></tr>
  <tr><td>Alternate email:</td><td>$altEmail&nbsp;</td></tr>
  <tr><td>Team status:</td><td>$newOld&nbsp;</td></tr>
  <tr><td>Comments: </td><td>$comments&nbsp;</td></tr>
</table>
EOF;
    }

  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

dbclose();

print <<<EOF
</body>
</html>
EOF;

/****************************************************************/

function getLeagues() {
  $sql=<<<EOF
SELECT id, name, night FROM leagues WHERE active=1
ORDER BY name, night
EOF;

  if($result=dbquery($sql)) {

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $name=$row['name'];
      $night=$row['night'];

      print <<<EOF
<option value="$id">$name - $night</option>
EOF;
    }

    mysqli_free_result($result);
  }else{
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}

?>
