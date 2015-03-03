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
<h1>Welcome!</h1>
<p>You have successfully subscribed to the PVA email <?= $list ?> list.</p>

<?php include("../footer.html"); ?>