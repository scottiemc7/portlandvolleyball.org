<?php include 'header.html.php'; ?>

<h1>Edit Scores</h1>

<?php
	require 'DB.php';
	$dsn = 'mysql://pvaDBusr:V0ll3y@mysql.portlandvolleyball.org/pvaDB';
	$dbh = DB::connect($dsn);
	if (DB::isError($dbh)) {
		die($dbh->getMessage());
	}

	$id = $_POST['id'];

	if ($_POST['id'] != "") {
		$bOK = true;
		$home1 = $_POST['home1'];
		$visitor1 = $_POST['visitor1'];
		$home2 = $_POST['home2'];
		$visitor2 = $_POST['visitor2'];
		$home3 = $_POST['home3'];
		$visitor3 = $_POST['visitor3'];
		$sql = "INSERT INTO scores (gameid, home1, visitor1, home2, visitor2, home3, visitor3) values($id, $home1, $visitor1, $home2, $visitor2, $home3, $visitor3)";
		echo $sql;
//		$status = $dbh->query($sql);
//		if(DB::isError($status)) {
//			die($status->getMessage());
//		} else {
//			echo "This game has been successfully edited.  <a href=\"games_add.php\">return to list</a>";
//		}
	}
	
	$qry = $dbh->getAll("SELECT * FROM scores WHERE s.gameid = $id");
	if (!$qry) {
		echo "<div style=\"width: 750px; font-weight: bold; text-align: center;\">There are no games to display.</div>";
	} else {
		foreach ($qry as $result) {
		$id = $result[0];
		$home1 = $result[1];
		$visitor1 = $result[2];
		$home2 = $result[3];
		$visitor2 = $result[4];
		$home3 = $result[5];
		$visitor3 = $result[6];
		}
	
?>
	
	<form name="editScores" class="eventForm" method="post">
	<table>	
		<tr>
			<td><input type="text" name="home1" value="<?php $home1 ?>" /></td> 
			<td><input type="text" name="visitor1" value="<?php $visitor1 ?>" /></td>
			<td><input type="text" name="home2" value="<?php $home2 ?>" /></td>
			<td><input type="text" name="visitor2" value="<?php $visitor2 ?>" /></td>
			<td><input type="text" name="home3" value="<?php $home3 ?>" /></td>
			<td><input type="text" name="visitor3" value="<?php $visitor3 ?>" /></td>

		</tr>
		<tr>
			<td><input type="submit" value="Edit Scores"></td>
		</tr>
	</table>
	<input type="hidden" name="id" value="<?php $id ?>" />
</form>

<form action="games_add.php" name="delete" style="margin-left: 70px;" method="post">
	<input type="hidden" name="delete" value="yes">
	<input type="hidden" name="id" value=
<?php
	echo "\"$id\">";
?>
	<input type="submit" value="Delete this game" onclick="javascript:return confirm('Really delete this game?')">
</form>
<?php
}
?>
</body>
</html>


