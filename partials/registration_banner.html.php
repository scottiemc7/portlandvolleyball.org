  <?php 

  require_once 'lib/mysql.php';
  require_once 'lib/support.php';
  $error=dbinit();
  if($error!=="") {
    print "***ERROR*** dbinit: $error\n";
    exit;
  }
  $season=getOne('reg_season');
  $lateDeadline=getOne('reg_latedeadline');
  $aryLateDeadline = explode('/',$lateDeadline);
  $dtFinalDeadline = mktime(23, 59, 59, $aryLateDeadline[0], $aryLateDeadline[1], $aryLateDeadline[2]);
  $timenow = time();
  $isOpen = $dtFinalDeadline >= $timenow;

  if($isOpen) {
  ?>

  <div class="pva-banner"><div class="container">
    Registration for <?php echo $season ?> is Open! <a class="btn btn-default" href="/register.php" onclick="ga('send', 'event', 'Banner', 'Click', 'Winter Registration');">Register!</a>
  </div></div>
  <?php } ?>