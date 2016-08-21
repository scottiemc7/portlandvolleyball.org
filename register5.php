<?php include("header.html"); ?>

<?php

  require 'DB.php';
  $dsn = 'mysql://pvaDBusr:V0ll3y@mysql.portlandvolleyball.org/pvaDB';
  $dbh = DB::connect($dsn);
  if (DB::isError($dbh)) {
    die($dbh->getMessage());
  }

  $season = $dbh->getOne("select value from vars where name = 'reg_season'");
  $deadline = $dbh->getOne("select value from vars where name = 'reg_deadline'");
  $lateDeadline = $dbh->getOne("select value from vars where name = 'reg_latedeadline'");
  $fee = $dbh->getOne("select value from vars where name = 'reg_fee'");
  $lateFee = $dbh->getOne("select value from vars where name = 'reg_latefee'");;
  $payPalFee = $dbh->getOne("select value from vars where name = 'reg_paypalfee'");  //2.9% + $.30
  $isSummer = $dbh->getOne("select value from vars where name = 'reg_isSummer'");
  $doublesFee = $dbh->getOne("select value from vars where name = 'reg_doublesFee'");
  $totalFee = $fee;

  $aryDeadline = explode('/',$deadline);
  $dtRegularDeadline = mktime(23, 59, 59, $aryDeadline[0], $aryDeadline[1], $aryDeadline[2]);
  $aryLateDeadline = explode('/',$lateDeadline);
  $dtFinalDeadline = mktime(23, 59, 59, $aryLateDeadline[0], $aryLateDeadline[1], $aryLateDeadline[2]);
  $timenow = time();
  $isClosed = $dtFinalDeadline - $timenow <= 0;
  $isLate = $dtRegularDeadline - $timenow <= 0;

  $registrationDeadline = date('l, F j, Y', $dtRegularDeadline);

  if($isClosed) {
  ?>
<p>We are no longer accepting online registrations.</p>
<?php
  }
  else {
    if($isLate)
      $totalFee += $lateFee;

    $statusMessage = "";

    $formSubmitted = false;

    //process form
    if ($_POST['teamName'] != "") {
      $bOK = true;
      $prob_spam = false;

      $teamName = $_POST['teamName'];
      if(strlen($teamName) == 0)
        $bOK = false;
  //    if(substr_count($teamName, '.net') + substr_count($teamName, '.com') + substr_count($teamName, '.org') > 0) {
  //      $prob_spam = true;
  //      $bOK = false;
  //    }
      $mgrName = $_POST['mgrName'];
      if($mgrName == "")
        $bOK = false;
      $mgrPhone = $_POST['phone1'];
      if($mgrPhone == "")
        $bOK = false;
      if(substr_count($mgrPhone, '5001020') > 0 || substr_count($mgrPhone, '123456') > 0) {
        $prob_spam = true;
        $bOK = false;
      }
      $mgrPhone2 = $_POST['phone2'];
      $mgrEmail = $_POST['email'];
      if($mgrEmail == "")
        $bOK = false;
      if(substr_count($mgrEmail, 'gawab.') > 0) {
        $prob_spam = true;
        $bOK = false;
      }
      $mgrEmail2 = $_POST['email2'];
      $altName = $_POST['alt_name'];
      $altPhone = $_POST['alt_phone1'];
      $altPhone2 = $_POST['alt_phone2'];
      $altEmail = $_POST['alt_email'];
      $league = $_POST['league'];
      $league2 = $_POST['league2'];
      //if($league == "")
        //bOK = false;
      $addr1 = $_POST['addr1'];
      if($addr1 == "")
        $bOK = false;
      $addr2 = $_POST['addr2'];
      //if($addr2 == "")
        //bOK = false;
      $city = $_POST['city'];
      //if($city == "")
        //bOK = false;
      $state = $_POST['state'];
      //if($state == "")
        //bOK = false;
      $zip = $_POST['zip'];
      //if($zip == "")
        //bOK = false;
      $comments = $_POST['comments'];
      if(substr_count($comments, 'drugs') > 0 || substr_count($comments, 'online store') > 0 || substr_count($comments, 'tramadol') > 0) {
        $prob_spam = true;
        $bOK = false;
      }

      if($league == "") {
                    $bOK = false;
                  }else{
                    $leaguename = $dbh->getAll("select name from registration_leagues where id = $league");
                    $leaguename = $leaguename[0][0];
      }
      if($league2 == "") {
                    $bOK = false;
                  }else{
                    $leaguename2 = $dbh->getAll("select name from registration_leagues where id = $league2");
                    $leaguename2 = $leaguename2[0][0];
      }
      $newOld=$_POST['newOld'];


      if($bOK == true) {

    // Prevent SQL injection
    $teamNameClean=mysql_real_escape_string($teamName);
    $mgrNameClean=mysql_real_escape_string($mgrName);
    $mgrPhoneClean=mysql_real_escape_string($mgrPhone);
    $mgrPhone2Clean=mysql_real_escape_string($mgrPhone2);
    $mgrEmailClean=mysql_real_escape_string($mgrEmail);
    $mgrEmail2Clean=mysql_real_escape_string($mgrEmail2);
    $altNameClean=mysql_real_escape_string($altName);
    $altPhoneClean=mysql_real_escape_string($altPhone);
    $altPhone2Clean=mysql_real_escape_string($altPhone2);
    $altEmailClean=mysql_real_escape_string($altEmail);
    $leagueClean=mysql_real_escape_string($league);
    $league2Clean=mysql_real_escape_string($league2);
    $addr1Clean=mysql_real_escape_string($addr1);
    $addr2Clean=mysql_real_escape_string($addr2);
    $cityClean=mysql_real_escape_string($city);
    $stateClean=mysql_real_escape_string($state);
    $zipClean=mysql_real_escape_string($zip);
    $commentsClean=mysql_real_escape_string($comments);
    $nightClean=mysql_real_escape_string($night);
    $newOldClean=mysql_real_escape_string($newOld);

        $sql="INSERT INTO registration(teamName, mgrName, mgrPhone, mgrPhone2,
              mgrEmail, mgrEmail2, altName, altPhone, altPhone2, altEmail, league, league2,
              addr1, addr2, city, state, zip, comments, night, newOld)
              VALUES('$teamNameClean', '$mgrNameClean', '$mgrPhoneClean', '$mgrPhone2Clean',
                                '$mgrEmailClean', '$mgrEmail2Clean', '$altNameClean', '$altPhoneClean',
                                '$altPhone2Clean', '$altEmailClean', '$leagueClean', '$league2Clean',
                                '$addr1Clean', '$addr2Clean', '$cityClean', '$stateClean',
              '$zipClean', '$commentsClean', '$nightClean', '$newOldClean')";
print "<p>sql=$sql</p>";
exit;
        $status = $dbh->query($sql);
        if (DB::isError($status)) {
          die($status->getMessage());
        }

        $statusMessage = "<p>$sql</p><p class=highlight>Wait!  You're not done yet!</p>";
        $formSubmitted = true;

        $mailstring = "Team: $teamName\r\n\r\nManager: $mgrName";
        $mailstring = "$mailstring\r\n\tPhone: $mgrPhone, $mgrPhone2\r\n\tEmail: $mgrEmail, $mgrEmail2";
        $mailstring = "$mailstring\r\n\r\nAlternate: $altName\r\n\tPhone: $altPhone, $altPhone2\r\n\tEmail: $altEmail";
        $mailstring = "$mailstring\r\n\r\nLeague: $leaguename\r\n2nd choice: $leaguename2";
        $mailstring = "$mailstring\r\n\r\nStatus: $newOld";
        $mailstring = "$mailstring\r\n\r\nComments: $comments";

        //mail("register@portlandvolleyball.org", "New registration - $teamName", $mailstring, "From: $mgrName<$mgrEmail>");
      }
      else if ($prob_spam == true) {
        $statusMessage = "<p class=highlight>Wait!  You're not done yet!</p>";
        $formSubmitted = true;
        $mailstring = "Team: $teamName\r\n\r\nManager: $mgrName";
        $mailstring = "$mailstring\r\n\tPhone: $mgrPhone, $mgrPhone2\r\n\tEmail: $mgrEmail, $mgrEmail2";
        $mailstring = "$mailstring\r\n\r\nAlternate: $altName\r\n\tPhone: $altPhone, $altPhone2\r\n\tEmail: $altEmail";
        $mailstring = "$mailstring\r\n\r\nLeague: $leaguename\r\n2nd choice: $leaguename2";
        $mailstring = "$mailstring\r\n\r\nStatus: $newOld";
        $mailstring = "$mailstring\r\n\r\nComments: $comments";

        //mail("pva@portlandvolleyball.org", "Probable pva reg spam - $teamName", $mailstring, "From: $mgrName<$mgrEmail>");
      }
      else {
        $statusMessage = "<p class=highlight>You forgot to fill in one or more required
        fields.<br />Please make sure all fields marked with an asterisk have been filled in.</p>";
      }
    }
  //$statusMessage = "<p class=highlight>Wait!  You're not done yet!</p>";
  //      $formSubmitted = true;
?>
<div id="content">
  <h1>
    Registration - <?php echo $season?>
  </h1>
<?=$statusMessage?>

  <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_xclick">
      <input type="hidden" name="business" value="info@portlandvolleyball.org">
        <input type="hidden" name="item_name" value="
          <?=$season?> Team Fee">
          <input type="hidden" name="amount" value="
            <?=$totalFee + $payPalFee?>">
            <input type="hidden" name="no_shipping" value="1">
              <input type="hidden" name="cn" value="Your Team Name">
                <input type="hidden" name="currency_code" value="USD">

                  <?php
if($formSubmitted == true) {
?>

                  <p>Your registration will not be complete until we've also received your payment for this season.</p>
                  <p>
                    The team fee for the <?=$season?> season is $<?=$fee?>.
// <div>
//   <b>NOTE: If registering a quads team then contact Michelle (<a href="mailto:info@portlandvolleyball.org">info@portlandvolleyball.org</a>) to pay.</b>
// </div>
                    <?php
    if($isLate) {
  ?>
                    Also, since it's after <?=$registrationDeadline?>, <b>
                      you now owe the $<?=$lateFee?> late fee
                    </b>.
                    <?php
  }
    if($isSummer) {
  ?>
                    <div>
                      <b>Doubles teams: </b> the fee is $<?=$doublesFee?>.  Please send your check by mail.
                    </div>
                    <?php
    }
  ?>
                    <p>
                      You have two payment options:
                      <ol>
                        <li>
                          Mail your check to:<br/>
                          Portland Volleyball Association<br/>
                          PO Box 25503<br/>
                          Portland, OR 97298-0503<br/>
                          <strong>
                            <em>Make sure to write your team name on your check.</em>
                          </strong>
                        </li>
                        <br/>
                        <li>
                          Pay online by clicking the PayPal Payments button.  PayPal will require you to sign up
                          for a free account, and an additional $<?=$payPalFee?> service fee will be charged
                          for all online payments.<br/>
                          <input type="image" src="https://www.paypal.com/images/x-click-but02.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast and secure!">
                          </li>
                      </ol>
                    </p>
                    <p style="font-weight: bold;">
                      Note: After <?=$registrationDeadline?>, a $<?=$lateFee?> late fee will
                      be added to the normal team fee.
                    </p>
                    <?php
}
else {
?>
                    <p>
                      To register, please fill in the information requested below and click the &quot;Register your team&quot;
                      button.  Required fields are marked with an asterisk (*).
                    </p>

                    <p>
                      The team fee for <?php echo $season?> is $<?php echo $fee?>.
<div>
  <b>NOTE: If registering a quads team then contact Michelle (<a href="mailto:info@portlandvolleyball.org">info@portlandvolleyball.org</a>) to pay.</b>
</div>
                      <?php
  if($isLate) {
  ?>
                      <b>
                        Also, since it's after
                        <?=$registrationDeadline?>, you owe the $<?php echo $lateFee?> late fee.
                      </b> Please include it
                      with your payment.
                      <?php
  }
  ?>
                    </p>

                    <p>
                      If you have already registered, but have not yet paid:
                      <table style="margin-left: 20px;">
                        <tr>
                          <td>
                            Mail your check to:<br/>
                            Portland Volleyball Association<br/>
                            PO Box 25503<br/>
                            Portland, OR 97298-0503<br/>
                            <em>Make sure to write the team name on your check.</em>
                          </td>
                          <td valign="top" style="padding-left: 15px;">
                            Pay using PayPal by clicking the button below.
                            <p>
                              <input type="image" src="https://www.paypal.com/images/x-click-but02.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast and secure!">
                            </p>
                          </td>
                        </tr>
                      </table>
                    </form>
  <form name="register" method="post" style="border: 1px solid #aaaaaa; padding: 40px;">
    <table>
      <tr>
        <td>Team Name*</td>
        <td>
          <input type="text" name="teamName" value="<?=$_POST['teamName']?>" size="40">
        </td>
      </tr>
      <tr>
        <td>Manager's Name*</td>
        <td>
          <input type="text" name="mgrName" value="<?=$_POST['mgrName']?>" size="40">
        </td>
      </tr>
      <tr>
        <td valign="top">Mailing Address*</td>
        <td>
          <input type="text" name="addr1" value="<?=$_POST['addr1']?>" size="40">
            <br>
              <input type="text" name="addr2" value="<?=$_POST['addr2']?>" size="40">
              </td>
      </tr>
      <tr>
        <td>City*</td>
        <td>
          <input type="text" name="city" value="<?=$_POST['city']?>" size="40">
        </td>
      </tr>
      <tr>
        <td>State*/Zip*</td>
        <td>
          <input type="text" name="state" value="<?=$_POST['state']?>" size="4" maxlength="2">
            &nbsp;<input type="text" name="zip" value="<?=$_POST['zip']?>" size="10" maxlength="10">
            </td>
      </tr>
      <tr>
        <td>Manager's Email Address*</td>
        <td>
          <input type="text" name="email" value="<?=$_POST['email']?>" size="40">
        </td>
      </tr>
      <tr>
        <td>Manager's Other Email Address</td>
        <td>
          <input type="text" name="email2" value="<?=$_POST['email2']?>" size="40">
        </td>
      </tr>
      <tr>
        <td>Daytime Phone*</td>
        <td>
          <input type="text" name="phone1" value="<?=$_POST['phone1']?>" size="40">
        </td>
      </tr>
      <tr>
        <td>Evening Phone</td>
        <td>
          <input type="text" name="phone2" value="<?=$_POST['phone2']?>" size="40">
        </td>
      </tr>
      <tr>
        <td>Alternate Contact</td>
        <td>
          <input type="text" name="alt_name" value="<?=$_POST['alt_name']?>" size="40">
        </td>
      </tr>
      <tr>
        <td>Alternate Work Phone</td>
        <td>
          <input type="text" name="alt_phone1" value="<?=$_POST['alt_phone1']?>" size="40">
        </td>
      </tr>
      <tr>
        <td>Alternate Home Phone</td>
        <td>
          <input type="text" name="alt_phone2" value="<?=$_POST['alt_phone2']?>" size="40">
        </td>
      </tr>
      <tr>
        <td>Alternate Email</td>
        <td>
          <input type="text" name="alt_email" value="<?=$_POST['alt_email']?>" size="40">
        </td>
      </tr>
      <tr>
        <td valign="top">
          League Requested*
        </td>
        <td>
          <?php
        $qryLeagues = $dbh->getAll("select id, name, night, (select count(*) from registration where league = registration_leagues.id and paid = 1)
as number from registration_leagues where active = 1 order by name, night");
?>
          <select name="league">
            <?php
  foreach($qryLeagues as $league){
//    if($league[3] < 8)
      echo("<option value=\"$league[0]\">$league[1] - $league[2]</option>");
  }
  ?>
          </select>
          <br/>
          <?php
  if(!$isSummer) {
?>
          <div style="font-size: 10px; color: #999999;">Women's leagues: AA is higher than A and BB is higher than B.</div>
          <?php
   }
?>
          <small>
            <b>
              Note: Registrations are not complete until your fee is paid in FULL.
              Your spot is not held just by signing up online.<br/>
              <?php
    if(!$isSummer) {
  ?>
              <b> There are a maximum number of 8 teams per league.</b> If the league you want is full, contact Michelle Baldwin at <a href="mailto:info@portlandvolleyball.org">info@portlandvolleyball.org</a>.
          </small>
          <?php
  }
  ?>
        </td>
      </tr>
      <tr>
        <td valign="top">
          2nd Choice* <br/>(in case 1st choice is full)
        </td>
        <td valign="top">
          <select name="league2">
            <?php
  foreach($qryLeagues as $league){
//    if($league[3] < 8)
      echo("<option value=\"$league[0]\">$league[1] - $league[2]</option>");
  }
  ?>
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
        <td>
          <textarea name="comments" cols="35" rows="5"><?=$_POST['comments']?></textarea>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
          <input type="submit" value="Register your team">
        </td>
      </tr>
    </table>
    <input type="hidden" name="formSubmitted" value="true">
    </form>
  <?php
}
?>

</div>
<?php
}
?>
<?php include("footer.html"); ?>
