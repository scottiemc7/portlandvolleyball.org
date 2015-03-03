<?php include("../header.html"); ?>
<?php 
require 'DB.php';
$dsn = 'mysql://pvaDBusr:V0ll3y@mysql.portlandvolleyball.org/pvaDB';
$dbh = DB::connect($dsn);
if (DB::isError($dbh)) {
die($dbh->getMessage());
}
$list = 'announcement';
if($_GET['l'] != '')
{
    $list = $_GET['l'];
}
?>
<h1>Almost done...</h1>
<p>
  To complete your registration for the PVA <?= $list ?> list, please check your email.
  You should receive a message with a confirmation link; use this to verify your email address.
</p>

<?php include("../footer.html"); ?>