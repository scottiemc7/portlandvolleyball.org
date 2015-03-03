<?php include("../header.html"); ?>
<?php 
require 'DB.php';
$dsn = 'mysql://pvaDBusr:V0ll3y@mysql.portlandvolleyball.org/pvaDB';
$dbh = DB::connect($dsn);
if (DB::isError($dbh)) {
die($dbh->getMessage());
}
?>
<h1>Email invalid</h1>
<p>The email address you entered was not valid.  Please check your entry and try again.</p>

<?php include("../footer.html"); ?>