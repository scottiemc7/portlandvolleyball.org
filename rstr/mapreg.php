<?php 

include("../header.html"); 

require 'DB.php';
$dsn = 'mysql://pvaDBusr:V0ll3y@mysql.portlandvolleyball.org/pvaDB';
$dbh = DB::connect($dsn);
if (DB::isError($dbh)) {
  die($dbh->getMessage());
}

#$dbh->setFetchMode(DB_FETCHMODE_ASSOC);
$dbh->setFetchMode(DB_FETCHMODE_ORDERED);

$map=array(  // registration_league.id => league.id
  1 => 78,   // Coed A Wednesday
  2 => 23,   // Coed A Thursday
  3 => 24,   // Coed B Wednesday
  4 => 30,   // Coed B Thursday
  5 => 25,   // Coed C Wednesday
  6 => 67,   // Coed C Thursday
  7 => 84,   // Coed D Wednesday
  8 => 33,   // Women's AA Tuesday
  //9 => 19,   // Women's A Tuesday
 10 => 20,   // Women's B Monday
 11 => 21,   // Women's C Monday
 12 => 22,   // Men's A Tuesday => Men's Tuesday
 13 => 22,   // Men's B Tuesday => Men's Tuesday
 14 => 82,   // Women's BB Monday
 24 => 88,   // Women's A Monday
 30 => 19,   // Women's A Tuesday
 31 => 93,   // Women's B Tuesday
);

print <<<EOF
<table border="1">
EOF;

foreach ($map as $key => $value) {

  #$qry = $dbh->getAll("SELECT * FROM registration_leagues WHERE active=1");
  $qry = $dbh->getAll("SELECT rl.id,rl.name,rl.night,rl.active,l.id,l.name,l.active FROM registration_leagues rl,leagues l WHERE rl.id=$key AND l.id=$value");
						
  if (!$qry) {
    print <<<EOF
<tr><td colspan="5">There are no items to display ($key -> $value)</td></tr>
EOF;
  }else{
    foreach($qry as $row){
      print "<tr>";
      foreach ($row as $key => $value) {
	if(strcmp($value,"") == 0) {
	  $value="&nbsp;";
	}
        print "<td>$value</td>";
      }
      print "</tr>\n";
    }
  } 
}

print <<<EOF
</table>
EOF;


?>

</body>
</html>
