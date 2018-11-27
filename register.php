<?php

require_once 'lib/mysql.php';
require_once 'lib/support.php';
include 'header.html.php';
$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

?>


<?php




$season=getOne('reg_season');
$deadline=getOne('reg_deadline');
$lateDeadline=getOne('reg_latedeadline');
$fee=getOne('reg_fee');
$lateFee=getOne('reg_latefee');
$payPalFee=getOne('reg_paypalfee');  // 2.9% + $0.30
$isSummer=getOne('reg_isSummer');
$doublesFee=getOne('reg_doublesFee');
$sandFee=getOne('reg_sandFee');
$totalFee=$fee;

$aryDeadline = explode('/',$deadline);
$dtRegularDeadline = mktime(23, 59, 59, $aryDeadline[0], $aryDeadline[1], $aryDeadline[2]);
$aryLateDeadline = explode('/',$lateDeadline);
$dtFinalDeadline = mktime(23, 59, 59, $aryLateDeadline[0], $aryLateDeadline[1], $aryLateDeadline[2]);
$timenow = time();
$isClosed = $dtFinalDeadline - $timenow <= 0;
$isLate = $dtRegularDeadline - $timenow <= 0;
$registrationDeadline = date('l, F j, Y', $dtRegularDeadline);

// custom code to handle special thursday double header leagues with higher price
$doubleHeaderFee = 528;
$doubleHeaderPayPalFee = $doubleHeaderFee * 0.029 + 0.30;
$doubleHeaderAmount = $doubleHeaderFee + $doubleHeaderPayPalFee;
// $doubleHeaderAmount = $doubleHeaderFee;
// end special thursday double header stuff
?>

<div id="content" class="container">
  <h1>
    Registration - <?php echo $season ?>
  </h1>
<?php
if($isClosed) {
  print <<<EOF
  <p>We are no longer accepting online registrations.</p>
EOF;
}else{
  if($isLate) $totalFee+=$lateFee;

  $statusMessage = "";
  $formSubmitted = false;

  //process form
  if($_POST['teamName'] != "") {
    $bOK = true;
    $prob_spam = false;

    $teamName = $_POST['teamName'];
    if(strlen($teamName) == 0) $bOK=false;
    //if(substr_count($teamName, '.net') + substr_count($teamName, '.com') + substr_count($teamName, '.org') > 0) {
    //  $prob_spam = true;
    //  $bOK = false;
    //}
    $mgrName = $_POST['mgrName'];
    if($mgrName == "") $bOK = false;
    $mgrPhone = $_POST['phone1'];
    if($mgrPhone == "") $bOK = false;
    if(substr_count($mgrPhone, '5001020') > 0 || substr_count($mgrPhone, '123456') > 0) {
      $prob_spam = true;
      $bOK = false;
    }
    $mgrPhone2 = $_POST['phone2'];
    $mgrEmail = $_POST['email'];
    if($mgrEmail == "") $bOK = false;
    if(substr_count($mgrEmail, 'gawab.') > 0) {
      $prob_spam = true;
      $bOK = false;
    }
    $mgrEmail2 = $_POST['email2'];
    $altName = $_POST['alt_name'];
    $altPhone = $_POST['alt_phone1'];
    $altPhone2 = $_POST['alt_phone2'];
    $altEmail = $_POST['alt_email'];
    $league=preg_replace('/[^\d]/','',$_POST['league']);
    $league2=preg_replace('/[^\d]/','',$_POST['league2']);
    //if($league == "") bOK = false;
    $addr1 = $_POST['addr1'];
    if($addr1 == "") $bOK = false;
    $addr2 = $_POST['addr2'];
    //if($addr2 == "") bOK = false;
    $city = $_POST['city'];
    //if($city == "") bOK = false;
    $state = $_POST['state'];
    //if($state == "") bOK = false;
    $zip = $_POST['zip'];
    //if($zip == "") bOK = false;
    $comments = $_POST['comments'];
    if(substr_count($comments, 'drugs') > 0 || substr_count($comments, 'online store') > 0 || substr_count($comments, 'tramadol') > 0) {
      $prob_spam = true;
      $bOK = false;
    }

    if($league == "") {
      $bOK = false;
    }else{
      if($result=dbquery("SELECT name, night FROM leagues WHERE id=$league")) {
        if($row=mysqli_fetch_assoc($result)) {
          $leaguename=$row['name'];
          $leaguenight=$row['night'];
        }else{
          $bOK = false;
        }
        mysqli_free_result($result);
      }else{
        $error=dberror();
        print "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
      }
    }
    if($league2 == "") {
      $bOK = false;
    }else{
      if($result=dbquery("SELECT name FROM leagues WHERE id=$league2")) {
        if($row=mysqli_fetch_assoc($result)) {
          $leaguename2=$row['name'];
          $leaguenight2=$row['night'];
        }else{
          $bOK = false;
        }
        mysqli_free_result($result);
      }else{
        $error=dberror();
        print "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
      }
    }

    $newOld=$_POST['newOld'];

    if($bOK == true) {

      // Prevent SQL injection
      $teamNameClean=dbescape($teamName);
      $mgrNameClean=dbescape($mgrName);
      $mgrPhoneClean=dbescape($mgrPhone);
      $mgrPhone2Clean=dbescape($mgrPhone2);
      $mgrEmailClean=dbescape($mgrEmail);
      $mgrEmail2Clean=dbescape($mgrEmail2);
      $altNameClean=dbescape($altName);
      $altPhoneClean=dbescape($altPhone);
      $altPhone2Clean=dbescape($altPhone2);
      $altEmailClean=dbescape($altEmail);
      $leagueClean=dbescape($league);
      $league2Clean=dbescape($league2);
      $addr1Clean=dbescape($addr1);
      $addr2Clean=dbescape($addr2);
      $cityClean=dbescape($city);
      $stateClean=dbescape($state);
      $zipClean=dbescape($zip);
      $commentsClean=dbescape($comments);
      $newOldClean=dbescape($newOld);

      $sql=<<<EOF
INSERT INTO registration(teamName, mgrName, mgrPhone, mgrPhone2,
mgrEmail, mgrEmail2, altName, altPhone, altPhone2, altEmail, league, league2,
addr1, addr2, city, state, zip, comments, newOld)
VALUES('$teamNameClean', '$mgrNameClean', '$mgrPhoneClean', '$mgrPhone2Clean',
'$mgrEmailClean', '$mgrEmail2Clean', '$altNameClean', '$altPhoneClean',
'$altPhone2Clean', '$altEmailClean', '$leagueClean', '$league2Clean',
'$addr1Clean', '$addr2Clean', '$cityClean', '$stateClean',
'$zipClean', '$commentsClean', '$newOldClean')
EOF;
      if(!dbquery($sql)) {
        $error=dberror();
        print "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
      }

      $statusMessage = "<p class=highlight>Wait!  You're not done yet!</p>";
      $formSubmitted = true;

      $mailstring=<<<EOF
Team: $teamName
Manager: $mgrName
Phone: $mgrPhone, $mgrPhone2
Email: $mgrEmail, $mgrEmail2
Alternate: $altName
Phone: $altPhone, $altPhone2
Email: $altEmail
League: $leaguename ($leaguenight)
2nd choice: $leaguename2 ($leaguenight2)
Status: $newOld
Comments: $comments

EOF;

      mail("register@portlandvolleyball.org", "New registration - $teamName", $mailstring, "From: $mgrName<$mgrEmail>");
    }elseif ($prob_spam == true) {
      $statusMessage = "<p class=highlight>Wait!  You're not done yet!</p>";
      $formSubmitted = true;

      $mailstring=<<<EOF
Team: $teamName
Manager: $mgrName
Phone: $mgrPhone, $mgrPhone2
Email: $mgrEmail, $mgrEmail2
Alternate: $altName
Phone: $altPhone, $altPhone2
Email: $altEmail
League: $leaguename ($leaguenight)
2nd choice: $leaguename2 ($leaguenight2)
Status: $newOld
Comments: $comments
EOF;

      //mail("pva@portlandvolleyball.org", "Probable pva reg spam - $teamName", $mailstring, "From: $mgrName<$mgrEmail>");
    }else{
      $statusMessage=<<<EOF
<p class="highlight">You forgot to fill in one or more required fields.<br />
Please make sure all fields marked with an asterisk have been filled in.</p>
EOF;
    }
  }
  //$statusMessage = "<p class=highlight>Wait!  You're not done yet!</p>";
  //$formSubmitted = true;

  $amount=$totalFee + $payPalFee;

  print <<<EOF
$statusMessage

EOF;

  if($formSubmitted == true) {
    print <<<EOF
<p>Your registration will not be complete until we've also received your payment for this season.</p>
<p>The team fee for $season is $$fee for Single Match, or $$doubleHeaderFee for Doubleheader leagues.
EOF;

    if($isLate) {
      print <<<EOF
Also, since it's after $registrationDeadline,
<b>you now owe the $$lateFee late fee</b>.
EOF;
    }

    print <<<EOF
<p>
You have two payment options:
<ol>
  <!--<li>
    Mail your check to:<br/>
    Portland Volleyball Association<br/>
    PO Box 92122<br/>
    Portland, OR 97292<br/>
    <strong><em>Make sure to write your team name on your check.</em></strong>
  </li>-->
  <br/>
  <li>
    <p>Pay online by clicking the PayPal Payments button.  PayPal will require you to sign up
    for a free account, and an additional service fee will be charged
    for all online payments.</p>

    <p>Pay for <strong>Single Match</strong> leagues using PayPal by clicking the button below.</p>

    <p>
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="business" value="pva@portlandvolleyball.org" />
        <input type="hidden" name="item_name" value="$season Team Fee" />
        <input type="hidden" name="amount" value="$amount" />
        <input type="hidden" name="no_shipping" value="1" />
        <input type="hidden" name="cn" value="Your Team Name" />
        <input type="hidden" name="currency_code" value="USD" />
        <input type="image" src="https://www.paypal.com/images/x-click-but02.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast and secure!" />
      </form>
    </p>

    <p>Pay for <strong>Doubleheader</strong> leagues using PayPal by clicking <em>this</em> button.</p>
    <p>
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="business" value="info@portlandvolleyball.org" />
        <input type="hidden" name="item_name" value="$season Double Header League Team Fee" />
        <input type="hidden" name="amount" value="$doubleHeaderAmount" />
        <input type="hidden" name="no_shipping" value="1" />
        <input type="hidden" name="cn" value="Your Team Name" />
        <input type="hidden" name="currency_code" value="USD" />
        <input type="image" src="https://www.paypal.com/images/x-click-but02.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast and secure!" />
      </form>
    </p>
  </li>
</ol>
</p>

<p style="font-weight: bold;">
Note: After $registrationDeadline, a $$lateFee late fee will be added to the normal team fee.
</p>

EOF;

  }else{
    print <<<EOF
<p>
To register, please fill in the information requested below and click the &quot;Register your team&quot;
button.  Required fields are marked with an asterisk (*).
</p>

<p>The team fee for $season is $$fee for Single Match leagues, or $$doubleHeaderFee for Doubleheader leagues.

EOF;

    if($isLate) {
      print <<<EOF
<b>
Also, since it's after $registrationDeadline,
you owe the $$lateFee late fee.
</b>
Please include it with your payment.

EOF;
    }

    $teamName=htmlentities($_POST['teamName']);
    $mgrName=htmlentities($_POST['mgrName']);
    $addr1=htmlentities($_POST['addr1']);
    $addr2=htmlentities($_POST['addr2']);
    $city=htmlentities($_POST['city']);
    $state=htmlentities($_POST['state']);
    $zip=htmlentities($_POST['zip']);
    $email=htmlentities($_POST['email']);
    $email2=htmlentities($_POST['email2']);
    $phone1=htmlentities($_POST['phone1']);
    $phone2=htmlentities($_POST['phone2']);
    $alt_name=htmlentities($_POST['alt_name']);
    $alt_email=htmlentities($_POST['alt_email']);
    $alt_phone1=htmlentities($_POST['alt_phone1']);
    $alt_phone2=htmlentities($_POST['alt_phone2']);
    $comments=htmlentities($_POST['comments']);

    print <<<EOF
</p>

<p><strong>If you have already registered, but have not yet paid:</strong></p>


  <div class="row">
    <!--<div class="col-xs-4">
      Mail your check to:<br/>
      Portland Volleyball Association<br/>
      PO Box 92122<br/>
      Portland, OR 97292<br/>
      <em>Make sure to write the team name on your check.</em>
    </div>-->
    <div class="col-xs-4">
      Pay for <strong>Single Match</strong> leagues using PayPal by clicking the button below.
      <p>
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="business" value="pva@portlandvolleyball.org" />
        <input type="hidden" name="item_name" value="$season Team Fee" />
        <input type="hidden" name="amount" value="$amount" />
        <input type="hidden" name="no_shipping" value="1" />
        <input type="hidden" name="cn" value="Your Team Name" />
        <input type="hidden" name="currency_code" value="USD" />
        <input type="image" src="https://www.paypal.com/images/x-click-but02.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast and secure!" />
      </form>
      </p>
    </div>
    <div class="col-xs-4">
      <p>Pay for <strong>Doubleheader</strong> leagues using PayPal by clicking <em>this</em> button.</p>
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="business" value="info@portlandvolleyball.org" />
        <input type="hidden" name="item_name" value="$season Double Header League Team Fee" />
        <input type="hidden" name="amount" value="$doubleHeaderAmount" />
        <input type="hidden" name="no_shipping" value="1" />
        <input type="hidden" name="cn" value="Your Team Name" />
        <input type="hidden" name="currency_code" value="USD" />
        <input type="image" src="https://www.paypal.com/images/x-click-but02.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast and secure!" />
      </form>
    </div>
  </div>

<form name="register" method="post" style="border: 1px solid #aaaaaa; padding: 40px; margin-top: 10px;">
<table>
  <tr>
    <td>Team Name*</td>
    <td><input type="text" name="teamName" value="$teamName" size="40" /></td>
  </tr>
  <tr>
    <td>Manager's Name*</td>
    <td><input type="text" name="mgrName" value="$mgrName" size="40" /></td>
  </tr>
  <tr>
    <td valign="top">Mailing Address*</td>
    <td><input type="text" name="addr1" value="$addr1" size="40" /><br />
        <input type="text" name="addr2" value="$addr2" size="40" /></td>
  </tr>
  <tr>
    <td>City*</td>
    <td><input type="text" name="city" value="$city" size="40" /></td>
  </tr>
  <tr>
    <td>State*/Zip*</td>
    <td><input type="text" name="state" value="$state" size="4" maxlength="2" />
        &nbsp;<input type="text" name="zip" value="$zip" size="10" maxlength="10" /></td>
  </tr>
  <tr>
    <td>Manager's Email Address*</td>
    <td><input type="text" name="email" value="$email" size="40" /></td>
  </tr>
  <tr>
    <td>Manager's Other Email Address</td>
    <td><input type="text" name="email2" value="$email2" size="40" /></td>
  </tr>
  <tr>
    <td>Daytime Phone*</td>
    <td><input type="text" name="phone1" value="$phone1" size="40" /></td>
  </tr>
  <tr>
    <td>Evening Phone</td>
    <td><input type="text" name="phone2" value="$phone2" size="40" /></td>
  </tr>
  <tr>
    <td>Alternate Contact</td>
    <td><input type="text" name="alt_name" value="$alt_name" size="40" /></td>
  </tr>
  <tr>
    <td>Alternate Work Phone</td>
    <td><input type="text" name="alt_phone1" value="$alt_phone1" size="40" /></td>
  </tr>
  <tr>
    <td>Alternate Home Phone</td>
    <td><input type="text" name="alt_phone2" value="$alt_phone2" size="40" /></td>
  </tr>
  <tr>
    <td>Alternate Email</td>
    <td><input type="text" name="alt_email" value="$alt_email" size="40" /></td>
  </tr>
  <tr>
    <td valign="top">League Requested*</td>
    <td><select name="league">
EOF;

    $leagueSelect="";

    $sql = '
      SELECT l.id, l.name, l.night, l.cap
      FROM leagues as l
      LEFT JOIN (SELECT league, count(*) as registrations
                 FROM registration
                 GROUP BY league) as r
      ON l.id = r.league
      WHERE l.active = 1 AND (name LIKE \'%Grass%\' OR name LIKE \'%Sand%\')
      AND (r.registrations IS NULL OR r.registrations < l.cap)
      ORDER BY l.name';

    if($result=dbquery($sql)) {
      while($row=mysqli_fetch_assoc($result)) {
        $id=$row['id'];
        $name=$row['name'];
        $night=$row['night'];

        $leagueSelect.=<<<EOF
<option value="$id">$name - $night</option>
EOF;
      }
      mysqli_free_result($result);
    }else{
      $error=dberror();
      print "***ERROR*** dbquery: Failed query<br />$error\n";
      exit;
    }

    print <<<EOF
$leagueSelect
</select>
<br />
EOF;

    if(!$isSummer) {
      print <<<EOF
<div style="font-size: 10px; color: #999999;">Women's leagues: AA is higher than A and BB is higher than B.</div>
EOF;
     }

    print <<<EOF
<small>
<b>
Note: Registrations are not complete until your fee is paid in FULL.
Your spot is not held just by signing up online.<br/>
</b>

EOF;

    print <<<EOF
<b>There is a maximum number of teams per league. Once a league is full it will no longer be listed here.</b>
If the league you want is not listed, contact Michelle Baldwin at <a href="mailto:info@portlandvolleyball.org">info@portlandvolleyball.org</a>.
</small>
EOF;

    print <<<EOF
    </td>
  </tr>
  <tr>
    <td valign="top">2nd Choice* <br/>(in case 1st choice is full)</td>
    <td valign="top">
      <select name="league2">
      $leagueSelect
      </select>
      <br/>
    </td>
  </tr>
  <tr>
    <td valign="top">Team Status*</td>
    <td valign="top">
      <select name="newOld">
        <option value="New team" selected="selected">New team</option>
        <option value="Returning team">Returning team</option>
      </select>
      <br />
      <small>
        (If "Returning team" and your team name and/or team manager has changed then
        enter your previous team name and manager in comments section below.)
      </small>
    </td>
  </tr>
  <tr>
    <td valign="top">Please enter any comments here.</td>
    <td><textarea name="comments" cols="35" rows="5">$comments</textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Register your team" /></td>
  </tr>
</table>
<input type="hidden" name="formSubmitted" value="true">
</form>
EOF;

  }

  print "</div>\n";
}

dbclose();

include("footer.html.php");

?>
