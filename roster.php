<?php

include("header.html");
include '/home/pva/portlandvolleyball.org/lib/mysql.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

//constants
$statusMessage="";
$addedMessage="";
	
$bOK = true;
$formSubmitted = false;
if($_POST['formSubmitted'] == "true") {
  $formSubmitted = true;
}
  
//process form
if ($formSubmitted == true) {
	
  $teamid=preg_replace('/[^\d]/','',$_POST['teamid']);
  if(strlen($teamid) == 0) $bOK = false;
		
  if(strlen($_POST['firstname1']) == 0) $bOK = false;
      
  $addedBy=preg_replace('/[^a-zA-Z\'\-\ ]/','',$_POST['addedBy']);
  $addedByClean=dbescape($addedBy);
  if($addedBy == "") $bOK = false;
 
  if($bOK == true) {    
    for($i=1; $i<=12; $i++) {
      $firstName=preg_replace('/[^a-zA-Z\'\-\ ]/','',$_POST['firstname'.$i]);
      $lastName=preg_replace('/[^a-zA-Z\'\-\ ]/','',$_POST['lastname'.$i]);
      $shirt=preg_replace('/[^LMSX]/','',$_POST['shirt'.$i]);

      // Prevent SQL injection
      $firstNameClean=dbescape($firstName);
      $lastNameClean=dbescape($lastName);

      if(strlen($firstName) > 0){
        $addedMessage.="<br/>".$firstName." ".$lastName;
        $sql=<<<EOF
INSERT INTO team_members(teamID, firstName, lastName, addedBy, dateAdded, shirtSize) 
VALUES($teamid, '$firstNameClean', '$lastNameClean', '$addedByClean', now(), '$shirt')
EOF;

        if(!dbquery($sql)) {
          $error=dberror();
          print "***ERROR*** dbquery: Failed query<br />$error\n";
          exit;
        }
      }
    }
  }else{
      $statusMessage=<<<EOF
<p class=highlight>You forgot to fill in one or more required fields.<br />
Please make sure all fields marked with an asterisk have been filled in.</p>
EOF;
  }
}

print <<<EOF
<div id="content">
<h1>Team Roster</h1>
$statusMessage

EOF;
		
if($formSubmitted == true && $bOK == true) {
  print <<<EOF
  <p>Thank you for updating your roster online.  You have added the following members to your team.</p>
  <p>$addedMessage</p>
  <p>For changes or deletions, please email Michelle Baldwin at 
    <script laguage="javascript">
      getMailto('info', 'portlandvolleyball.org');
    </script>
</p>
EOF;

}else{

  $teamid="";
  if(isset($_POST['teamid'])) {
    $teamid=preg_replace('/[^\d]/','',$_POST['teamid']);
  }

  $addedBy="";
  if(isset($_POST['addedBy'])) {
    $addedBy=preg_replace('/[^a-zA-Z\'\-\ ]/','',$_POST['addedBy']);
  }

  print <<<EOF
<form name="roster" method="post" style="border: 1px solid #aaaaaa; padding: 40px;">
  <input type="hidden" name="formSubmitted" value="true" />
  <table>
    <tr>
      <td>Team*</td>
      <td>
EOF;

  $sql=<<<EOF
SELECT r.id AS id, r.teamname AS team, rl.name AS league, rl.night AS night
FROM registration_leagues rl
JOIN registration r on rl.id = r.league
ORDER BY rl.name, rl.night, r.teamname
EOF;

  print <<<EOF
<select name="teamid">
<option value="">Select your team from the list</option>
EOF;

  if($result=dbquery($sql)) {
  
    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $team=$row['team'];
      $league=$row['league'];
      $night=$row['night'];

      $selected = "";
      if($id == $teamid) $selected=' selected="selected"';
      print <<<EOF
<option value="$id"$selected>$league $night - $team</option>
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
      <td>Your Name*</td>
      <td>
        <input type="text" name="addedBy" value="$addedBy" size="40" />
      </td>
    </tr>
    <tr>
      <td valign="top">Players*</td>
      <td valign="top">
        <table>
          <tr>
            <td style="font-weight: bold;">First Name</td>
            <td style="font-weight: bold;">Last Name</td>
            <td style="font-weight: bold;">T-shirt Size</td>
          </tr>
EOF;

  for($i=1; $i<=12; $i++) {
    $firstname=preg_replace('/[^a-zA-Z\'\-\ ]/','',$_POST['firstname'.$i]);
    $lastname=preg_replace('/[^a-zA-Z\'\-\ ]/','',$_POST['lastname'.$i]);
    $shirt=preg_replace('/[^LMSX]/','',$_POST['shirt'.$i]);

    print <<<EOF
          <tr>
            <td>
              <input type="text" name="firstname$i" value="$firstname" size="40" />
            </td>
            <td>
              <input type="text" name="lastname$i" value="$lastname" size="40" />
            </td>
            <td>
              <select name="shirt$i">
EOF;
    $sizes=array("XSM","SM","M","L","XL","XXL");
    foreach($sizes as $size) {
      $selected="";
      if($shirt===$size) $selected=' selected="selected"';
      print <<<EOF
                <option value="$size"$selected>$size</option>
EOF;
    }
    print <<<EOF
              </select>
            </td>
          </tr>
EOF;
  }

  print <<<EOF
        </table>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
        <input type="submit" value="Submit roster" />
      </td>
    </tr>
  </table>
</form>
EOF;

}

dbclose();

include("footer.html");
?>
