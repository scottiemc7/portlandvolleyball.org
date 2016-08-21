<?php include 'header.html'; ?>

<?php
  require 'DB.php';
  $dsn = 'mysql://pvaDBusr:V0ll3y@mysql.portlandvolleyball.org/pvaDB';
  $dbh = DB::connect($dsn);
  if (DB::isError($dbh)) {
      die($dbh->getMessage());
  }

  if ($_POST['league'] != '') {
      $leagueid = $_POST['league'];
      $dbh->query("update registration set league = $leagueid
          WHERE id = $id");
  }

  $qry = $dbh->getAll("SELECT r.id, teamname, rl.name, rl.night, mgrName, mgrPhone, mgrPhone2, mgrEmail, mgrEmail2,
            addr1, addr2, city, state, zip, altName, altPhone, altEmail, comments, rl2.name, rl2.night
            FROM ((registration r left join registration_leagues rl on rl.id = r.league) left join registration_leagues rl2 on rl2.id = r.league2)
            WHERE r.id = $id");

  if (!$qry) {
      echo 'div style="width: 750px; font-weight: bold; text-align: center;">There are no items to display.</div>';
  } else {
      ?>

    <h1>Team Details</h1>

    <form method="post">
      Change league to:
      <?php
        $qryLeagues = $dbh->getAll('select id, name, night from registration_leagues where active = 1'); ?>
      <select name="league">
        <option value="">-- Select --</option>
        <?php
        foreach ($qryLeagues as $league) {
            echo "<option value=\"$league[0]\">$league[1] - $league[2]</option>";
        } ?>
      </select>
      <input type="submit" value="Change" />
    </form>
<br/>
<br/>
<table>
  <tr>
    <td>
      <?php
      foreach ($qry as $result) {
          echo"
        <table border=\"1\" cellspacing=\"0\" cellpadding=\"3\" valign=\"top\">
          <tr><td>Team name:</td><td>$result[1]</td></tr>
          <tr><td>League:</td><td>$result[2] $result[3]</td></tr>
          <tr><td>2nd choice:</td><td>$result[18] $result[19]</td></tr>
          <tr><td>Manager:</td><td>$result[4]</td></tr>
          <tr><td>Phone:</td><td>$result[5], $result[6]</td></tr>
          <tr><td>Email:</td><td>$result[7], $result[8]</td></tr>
          <tr><td valign=\"top\">Address:</td><td>$result[9]<br>$result[10]<br>$result[11], $result[12]  &nbsp;$result[13]</td></tr>
          <tr><td>Alternate contact:</td><td>$result[14]&nbsp;</td></tr>
          <tr><td>Alternate phone:</td><td>$result[15]&nbsp;</td></tr>
          <tr><td>Alternate email:</td><td>$result[16]&nbsp;</td></tr>
          <tr><td>Comments: </td><td>$result[17]&nbsp;</td></tr>
        </table>
       </td>
       <td valign=\"top\" style=\"padding-left: 20px;\">";

          $qryRoster = $dbh->getAll('select firstname, lastname, addedby, dateadded from team_members where teamid = '.$result[0]);
          if ($qryRoster) {
              echo '<h2>Roster</h2><table class="eventTable" cellspacing="0" cellpadding="6"><tr><th>Player</th><th>Added by</th><th>Date added</th></tr>';
              foreach ($qryRoster as $player) {
                  echo "<tr><td>$player[0] $player[1]</td><td>$player[2]</td><td>$player[3]&nbsp;</td></tr>";
              }
              echo '</table>';
          }
      }
  }
?>
    </td>
  </tr>
</table>
</body>
</html>