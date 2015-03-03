<?php include("header.html"); ?>

<?php

$dtRegularDeadline = mktime(0,0,0,5,20,2006);
$dtFinalDeadline = mktime(0, 0, 0, 5, 25, 2006);
$timenow = time();


if($timenow > $dtFinalDeadline) {

//if($isLate) {
?>
<p>We are no longer accepting online registrations.</p>
<?php
}
else {
	require 'DB.php';
	$dsn = 'mysql://pvaDBusr:V0ll3y@mysql.portlandvolleyball.org/pvaDB';
	$dbh = DB::connect($dsn);
	if (DB::isError($dbh)) {
		die($dbh->getMessage());
	}

	//constants
	$season = 'Summer 2006';
	$fee = 160.00;

	if($_POST['division'] == "Reverse Coed Grass Doubles")
		$fee = 40.00;
		
	$lateFee = 15.00;
	$payPalFee = 5.00;
	$registrationDeadline = 'Friday, May 19';
	$totalFee = $fee;
	$isLate = $timenow > $dtRegularDeadline;
	
	if($isLate)
		$totalFee += $lateFee;
	
	$statusMessage = "";
	
	$formSubmitted = false;
	
	//process form
	if ($_POST['teamname'] != "") {
		$bOK = true;
		
		$teamName = $_POST['teamname'];
		//if(strlen($teamName) == 0)
			//bOK = false;
		$mgrName = $_POST['mgrName'];
		//if($mgrName == "")
			//bOK = false;
		$mgrPhone = $_POST['phone1'];
		//if($mgrPhone == "")
			//bOK = false;
		$mgrPhone2 = $_POST['phone2'];
		$mgrEmail = $_POST['email'];
		//if($mgrEmail == "")
			//bOK = false;
		$mgrEmail2 = $_POST['email2'];
		$altName = $_POST['alt_name'];
		$altPhone = $_POST['alt_phone1'];
		$altPhone2 = $_POST['alt_phone2'];
		$altEmail = $_POST['alt_email'];
		$division = $_POST['division'];
		
		//if($division == "")
			//bOK = false;
		$league = $_POST['league'];
		//if($league == "")
			//bOK = false;
		$addr1 = $_POST['addr1'];
		//if($addr1 == "")
			//bOK = false;
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
		$night = $_POST['night'];
		 
		if($bOK == true) {
			$status = $dbh->query("INSERT INTO registration(teamName, mgrName, mgrPhone, mgrPhone2,
				mgrEmail, mgrEmail2, altName, altPhone, altPhone2, altEmail, division, league,
				addr1, addr2, city, state, zip, comments, night) 
				VALUES('$teamName', '$mgrName', '$mgrPhone', '$mgrPhone2', '$mgrEmail', '$mgrEmail2', '$altName', 
				'$altPhone', '$altPhone2', '$altEmail', '$division', '$league', '$addr1', '$addr2', '$city', '$state', 
				'$zip', '$comments', '$night')");
			if (DB::isError($status)) {
				die($status->getMessage());
			}
			
			$statusMessage = "<p class=highlight>Wait!  You're not done yet!</p>";
			$formSubmitted = true;
			$mailstring = "Team: $teamname\r\n\r\nManager: $mgrName";
			$mailstring = "$mailstring\r\n\tPhone: $mgrPhone, $mgrPhone2\r\n\tEmail: $mgrEmail, $mgrEmail2";
			$mailstring = "$mailstring\r\n\r\nAlternate: $altName\r\n\tPhone: $altPhone, $altPhone2\r\n\tEmail: $altEmail";
			$mailstring = "$mailstring\r\n\r\nDivision: $division"; //\r\nLeague: $league\r\nNight: $night";
			$mailstring = "$mailstring\r\n\r\nComments: $comments";
			
			mail("register@portlandvolleyball.org", "New registration - $teamname", $mailstring, "From: $mgrName<$mgrEmail>");
		}
		else {
			$statusMessage = "<p class=highlight>You forgot to fill in one or more required 
			fields.  Please make sure all fields marked with an asterisk have been filled in.</p>";
		}
	}
?>
<div id="content">
<h1>Registration - <?php echo $season?></h1>
<?=$statusMessage?>

<?php 
if($formSubmitted == true) {
?>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="info@portlandvolleyball.org">
		<input type="hidden" name="item_name" value="<?=$season?> Team Fee">
		<input type="hidden" name="amount" value="<?=$totalFee + $payPalFee?>">
		<input type="hidden" name="no_shipping" value="1">
		<input type="hidden" name="cn" value="Your Team Name">
		<input type="hidden" name="currency_code" value="USD">
		
		<p>Your registration will not be complete until we've also received your payment for this season.</p>
		<p>The team fee for the <?=$season?> season is $<?=$fee?>. 
	<?php
		if($isLate) {
	?>
		Also, since it's after <?=$registrationDeadline?>, <b>you now owe the $<?=$lateFee?> late fee</b>.  
	<?php
	} 
	?>
		You have two payment options:
			<ol>
				<li>Mail your check to:<br/>
				Portland Volleyball Association<br/>
				PO Box 4684<br/>
				Portland, OR 97208<br/>
				<strong><em>Make sure to write your team name on your check.</em></strong></li><br/>
				<li>
				Pay online by clicking the PayPal Payments button.  PayPal will require you to sign up 
				for a free account, and an additional $<?=$payPalFee?>.00 service fee will be charged 
				for all online payments.<br/>
				<input type="image" src="https://www.paypal.com/images/x-click-but02.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast and secure!">
				</li>
			</ol>
			
		<p style="font-weight: bold;">Note: After <?=$registrationDeadline?>, a $<?=$lateFee?> late fee will 
		be added to the normal team fee.</p>
	</form>
<?php
}
else {
?>
	<p>To register, please fill in the information requested below and click the &quot;Register your team&quot; 
	button.  Required fields are marked with an asterisk (*).</p>

	<p>If you have already registered, but have not yet paid, you can mail your check to Portland Volleyball 
	Association, PO Box 4684, Portland, OR 97208. <em>Make sure to write the team name on your check.</em>  
	The team fee for <?php echo $season?> is $<?php echo $fee?> ($40 for doubles teams).  
	<?php
	if($isLate){
	?>
	<b>Also, since it's after 
	<?=$registrationDeadline?>, you owe the $<?php echo $lateFee?> late fee.</b> Please include it 
	with your payment.
	<?php
	}
	?>

<form name="register" method="post">
	<table>
		<tr>
			<td>Team Name*</td>
			<td><input type="text" name="teamname" value="<?=$_POST['teamname']?>" size="40"></td>
		</tr>
		<tr>
			<td>Manager's Name*</td>
			<td><input type="text" name="mgrName" value="<?=$_POST['mgrName']?>" size="40"></td>
		</tr>
		<tr>
			<td valign="top">Mailing Address*</td>
			<td><input type="text" name="addr1" value="<?=$_POST['addr1']?>" size="40"><br>
				<input type="text" name="addr2" value="<?=$_POST['addr2']?>" size="40">
			</td>
		</tr>
		<tr>
			<td>City*</td>
			<td><input type="text" name="city" value="<?=$_POST['city']?>" size="40"></td>
		</tr>
		<tr>
			<td>State*/Zip*</td>
			<td><input type="text" name="state" value="<?=$_POST['state']?>" size="4" maxlength="2"> 
				&nbsp;<input type="text" name="zip" value="<?=$_POST['zip']?>" size="10" maxlength="10">
			</td>
		</tr>
		<tr>
			<td>Manager's Email Address*</td>
			<td><input type="text" name="email" value="<?=$_POST['email']?>" size="40"></td>
		</tr>
		<tr>
			<td>Manager's Other Email Address</td>
			<td><input type="text" name="email2" value="<?=$_POST['email2']?>" size="40"></td>
		</tr>
		<tr>
			<td>Daytime Phone*</td>
			<td><input type="text" name="phone1" value="<?=$_POST['phone1']?>" size="40"></td>
		</tr>
		<tr>
			<td>Evening Phone</td>
			<td><input type="text" name="phone2" value="<?=$_POST['phone2']?>" size="40"></td>
		</tr>
		<tr>
			<td>Alternate Contact</td>
			<td><input type="text" name="alt_name" value="<?=$_POST['alt_name']?>" size="40"></td>
		</tr>
		<tr>
			<td>Alternate Work Phone</td>
			<td><input type="text" name="alt_phone1" value="<?=$_POST['alt_phone1']?>" size="40"></td>
		</tr>
		<tr>
			<td>Alternate Home Phone</td>
			<td><input type="text" name="alt_phone2" value="<?=$_POST['alt_phone2']?>" size="40"></td>
		</tr>
		<tr>
			<td>Alternate Email</td>
			<td><input type="text" name="alt_email" value="<?=$_POST['alt_email']?>" size="40"></td>
		</tr>
		<tr>
			<td>Division</td>
			<td>
				<select name="division">
					<option value="">-- Choose Division --</option>
					<option value="Women's Grass 4's">Women's Grass 4's</option>
					<option value="Men's Grass 4's">Men's Grass 4's</option>
					<option value="Reverse Coed Grass 4's">Reverse Coed Grass 4's</option>
					<option value="Coed Grass 6's">Coed Grass 6's</option>
					<option value="Reverse Coed Grass Doubles">Reverse Coed Grass Doubles</option>
					<option value="Coed Sand 4's">Coed Sand 4's</option>
					<option value="Coed Sand 6's">Coed Sand 6's</option>
				</select>
			</td>
		</tr>

		<tr>
			<td valign="top">&nbsp;</td>
			<td><small><b>Divisions/Nights</b><br>
				Mon- Women’s 4’s Grass, Men’s 4’s Grass<br/>
				Tues- Reverse Coed 4’s Grass<br/>
				Wed- Coed 6’s Grass, Coed 4’s Sand<br/>
				Thur- Coed Grass Reverse Doubles, Coed 6’s Sand
			    </small>
			</td>
		</tr>

		<tr>
			<td valign="top">Please enter any comments here.</td>
			<td><textarea name="comments" cols="35" rows="5"><?=$_POST['comments']?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" value="Register your team"></td>
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