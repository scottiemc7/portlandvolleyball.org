<?php include 'header.html.php'; ?>

<?php
	require 'DB.php';
	$dsn = 'mysql://pvaDBusr:V0ll3y@mysql.portlandvolleyball.org/pvaDB';
	$dbh = DB::connect($dsn);
	if (DB::isError($dbh)) {
		die($dbh->getMessage());
	}
?>


<h1>Current Games</h1>
<table cellpadding="6" cellspacing="0" width="750" class="eventTable">
	<tr>
		<th>Date</th>
		<th>Time</th>
		<th>Home</th>
		<th>Visitor</th>
		<th>Location</th>
		<th nowrap="nowrap">Game 1</th>
		<th nowrap="nowrap">Game 2</th>
		<th nowrap="nowrap">Game 3</th>
		<th>&nbsp;</th>
	</tr>
<?php
	$qry = $dbh->getAll("SELECT teams.name, t.name, gyms.name, dt, tm, g.id, s.* FROM ((((games g LEFT JOIN teams ON teams.id = g.visitor) LEFT JOIN gyms ON gyms.id = g.gym) LEFT JOIN teams t ON t.id = g.home) LEFT JOIN scores s on s.gameid = g.id) WHERE gyms.name <> 'BYE' ORDER BY dt, tm");
	foreach ($qry as $result) {
	$dtarray = explode('-', $result[3]);
	$tmarray = explode(':', $result[4]);
	echo "<tr";
	if ($result[6] != 0) {echo " style=\"background-color: #ffff99;\"";}
	echo ">";
	echo "	<td valign=\"top\">";
	printf("%d/%d/%d</td>", $dtarray[1], $dtarray[2], $dtarray[0]);
	echo "	<td valign=\"top\">";
	printf("%d:%02d</td>", $tmarray[0], $tmarray[1]);
	echo "	<td valign=\"top\">$result[1]</td>";
	echo "	<td valign=\"top\">$result[0]</td>";		
	echo "	<td valign=\"top\">$result[2]</td>";
	echo "  <td>";
	echo "  $result[7] - $result[8] ";
	echo "  </td>";
	echo "  <td>";
	echo "  $result[9] - $result[10] ";
	echo "  </td>";
	echo "  <td>";
	echo "  $result[11] - $result[12] ";
	echo "  </td>";
	echo "	<td>";
	echo "	<form action=\"scores_edit.php\" method=\"post\">";
	echo "		<input type=\"submit\" value=\"Edit\">";
	echo "		<input type=\"hidden\" name=\"id\" value=\"$result[5]\">";
	echo "	</form>";
	echo "	</td>";
	echo "	</tr>";
	}
	
?>
</table>


</body>
</html>
