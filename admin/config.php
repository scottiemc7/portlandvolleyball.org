<?php

include 'header.html';
include '/home/pva/portlandvolleyball.org/lib/mysql.php';
include '/home/pva/portlandvolleyball.org/lib/support.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}
	
$statusSummary = "";
 
if(isset($_POST['season'])) {
  $value=preg_replace('/[^a-zA-Z0-9\,\ ]/','',$_POST['season']);
  if(empty($value)) {
    $statusSummary.="<br />Invalid season";
  }else{
    setOne('reg_season',$value);
  }
}
 
if(isset($_POST['deadline'])) {
  $value=preg_replace('/[^0-9\/]/','',$_POST['deadline']);
  $aryDeadline=explode('/',$value);
  if(!checkdate($aryDeadline[0], $aryDeadline[1], $aryDeadline[2])) {
    $statusSummary.="<br />Invalid deadline";
  }else{
    setOne('reg_deadline',$value);
  }
}
 
if(isset($_POST['lateDeadline'])) {
  $value=preg_replace('/[^0-9\/]/','',$_POST['lateDeadline']);
  $aryDeadline=explode('/',$value);
  if(!checkdate($aryDeadline[0], $aryDeadline[1], $aryDeadline[2])) {
    $statusSummary.="<br />Invalid late deadline";
  }else{
    setOne('reg_lateDeadline',$value);
  }
}
 
if(isset($_POST['fee'])) {
  $value=preg_replace('/[^0-9]/','',$_POST['fee']);
  if(empty($value)) {
    $statusSummary.="<br />Invalid fee";
  }else{
    setOne('reg_fee',$value);
  }
}
 
if(isset($_POST['lateFee'])) {
  $value=preg_replace('/[^0-9]/','',$_POST['lateFee']);
  if(empty($value)) {
    $statusSummary.="<br />Invalid late fee";
  }else{
    setOne('reg_lateFee',$value);
  }
}
 
if(isset($_POST['payPalFee'])) {
  $value=preg_replace('/[^0-9\.]/','',$_POST['payPalFee']);
  if(empty($value)) {
    $statusSummary.="<br />Invalid PayPal fee";
  }else{
    setOne('reg_payPalFee',$value);
  }
}
 
if(isset($_POST['isSummer'])) {
  setOne('reg_isSummer','1');
}else{
  setOne('reg_isSummer','0');
}
 
if(isset($_POST['doublesFee'])) {
  $value=preg_replace('/[^0-9]/','',$_POST['doublesFee']);
  if(empty($value)) {
    $statusSummary.="<br />Invalid doubles fee";
  }else{
    setOne('reg_doublesFee',$value);
  }
}
 
if(isset($_POST['sandFee'])) {
  $value=preg_replace('/[^0-9]/','',$_POST['sandFee']);
  if(empty($value)) {
    $statusSummary.="<br />Invalid sand fee";
  }else{
    setOne('reg_sandFee',$value);
  }
}
  
if($statusSummary=="" && $_POST['season']!="") { 
  $statusSummary = "Your changes have been saved."; 
}
  
$season=getOne('reg_season');
$deadline=getOne('reg_deadline');
$lateDeadline=getOne('reg_latedeadline');
$fee=getOne('reg_fee');
$lateFee=getOne('reg_latefee');
$payPalFee=getOne('reg_paypalfee');  //2.9% + $.30
$isSummer=getOne('reg_isSummer');
$doublesFee=getOne('reg_doublesFee');  
$sandFee=getOne('reg_sandFee');  

dbclose();

$checked='';
if($isSummer=="1") {
  $checked='checked="checked"';
}

print <<<EOF

<h1>Configuration settings</h1>

<p class="error">
$statusSummary
</p>

<form method="post">
<table>
  <tr>
    <td>Season</td>
    <td><input type="text" name="season" value="$season" /></td>
  </tr>
  <tr>
    <td>Deadline (m/d/yyyy)</td>
    <td><input type="text" name="deadline" value="$deadline" />
  </td>
  </tr>
  <tr>
    <td>Late deadline (m/d/yyyy)</td>
    <td><input type="text" name="lateDeadline" value="$lateDeadline" /></td>
  </tr>
  <tr>
    <td>Fee</td>
    <td>$ <input type="text" id="fee" name="fee" value="$fee" onblur="calculatePayPalFee();" size="8" /></td>
  </tr>
  <tr>
    <td>PayPal fee</td>
    <td>
      <div style="float:left;">$ <input type="text" id="payPalFee" name="payPalFee" value="$payPalFee" size="8" /></div>
      <div id="payPalFeeChanged" style="float:left;display:none;margin-left: 10px;">PayPal fee automatically calculated to the nearest $.10.</div>
    </td>
  </tr>
  <tr>
    <td>Late fee</td>
    <td>$ <input type="text" name="lateFee" value="$lateFee" size="8" /></td>
  </tr>
  <tr>
    <td>Is summer?</td>
    <td><input type="checkbox" name="isSummer" $checked /></td>
  </tr>
  <tr>
    <td>Doubles fee (summer only)</td>
    <td>$ <input type="text" name="doublesFee" value="$doublesFee" size="8" /></td>
  </tr>
  <tr>
    <td>Sand fee (summer only)</td>
    <td>$ <input type="text" name="sandFee" value="$sandFee" size="8" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Save" /></td>
  </tr>
</table>
</form>

<script type="text/javascript">
  function calculatePayPalFee(){
    var fee = document.getElementById('fee').value;
    var paypalfee = (fee * .029) + .30;
    paypalfee = Math.round(paypalfee*10)/10;
    paypalfee = paypalfee.toFixed(2);
    document.getElementById('payPalFee').value = paypalfee;
    document.getElementById('payPalFeeChanged').style.display = 'block';
  }
</script>
EOF;
