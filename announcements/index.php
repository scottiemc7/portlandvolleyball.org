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
<h1>Sign up for the <?= $list ?> list
</h1>
<p>
  To sign up for the PVA <?= $list ?> list, enter your name and email below.  We will send
you information pertaining to the league, registrations, etc.
<form method="post" action="http://scripts.dreamhost.com/add_list.cgi">
    <input type="hidden" name="list" value="<?= $list ?>@portlandvolleyball.org" />
    <input type="hidden" name="domain" value="portlandvolleyball.org" />
    <input type="hidden" name="emailit" value="0" />
    <div style="float: left; width: 50px;">Name:</div>
    <input name="name" />
    <br/>
    <div style="float: left; width: 50px; height: 30px;">E-mail:</div>
    <input name="email" />
    <br clear="both" />
    <input type="submit" name="submit" value="Sign up" />
  </form>

  <p>Note:  we will never share your email address with anybody, and you can unsubscribe at any time.  We hate spam as much as you do.</p>
<?php include '../footer.html'; ?>