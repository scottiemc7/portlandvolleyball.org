<?php include '../header.html'; ?>
<?php
require 'DB.php';
$dsn = 'mysql://pvaDBusr:V0ll3y@mysql.portlandvolleyball.org/pvaDB';
$dbh = DB::connect($dsn);
if (DB::isError($dbh)) {
    die($dbh->getMessage());
}

$list = 'announcements';
if ($_GET['l'] != '') {
    $list = $_GET['l'];
}
?>
<h1>Unsubscribe</h1>
<p>Tired of receiving updates from PVA?  We're sorry to see you go, but we understand.</p>
  <form method="post" action="http://scripts.dreamhost.com/add_list.cgi">
     <input type="hidden" name="list" value="<?= $list ?>@portlandvolleyball.org" />
     <input type="hidden" name="domain" value="portlandvolleyball.org" />
     <input type="hidden" name="emailit" value="0" />
     <div style="float: left; width: 50px; height: 30px;">E-mail:</div> <input name="email" /><br clear="both" />
     <input type="submit" name="unsub" value="Unsubscribe" />
  </form>

<?php include '../footer.html'; ?>