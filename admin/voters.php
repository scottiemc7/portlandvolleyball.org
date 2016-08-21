<?php

session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    // Already logged in
} else {
    // Must be logged in first
  header('Location: login.php');
    exit;
}

require 'DB.php';
$dsn = 'mysql://pvaDBusr:V0ll3y@mysql.portlandvolleyball.org/pvaDB';
$dbh = DB::connect($dsn);
if (DB::isError($dbh)) {
    die($dbh->getMessage());
}

$qry = $dbh->getAll('SELECT r.id, rl.name, rl.night, teamname, mgrName, mgrEmail, mgrEmail2 FROM (registration2 r left join registration_leagues2 rl on rl.id = r.league) ORDER BY rl.name, rl.night, teamname');

$contents = '';
if (!$qry) {
    $contents = "There are no items to display.\n";
} else {
    $contents = "ID\tLeague\tNight\tTeam Name\tManager's First Name\tManager's Last Name\tEmail\tEmail2\n";
    foreach ($qry as $result) {
        $firstname = $result[4];
        $lastname = '';
        if (preg_match('#^\s*(\S+)\s+(.*)$#', $result[4], $matches)) {
            $firstname = $matches[1];
            $lastname = $matches[2];
        }
        $contents .= "$result[0]\t$result[1]\t$result[2]\t$result[3]\t$firstname\t$lastname\t$result[5]\t$result[6]\n";
    }
}
header('Content-type: application/octet-stream');
header('Content-disposition: attachment; filename=voters.csv');
echo $contents;
