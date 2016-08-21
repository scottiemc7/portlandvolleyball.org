<?php include("header.html"); ?>

<?php
  require 'DB.php';
  $dsn = 'mysql://pvaDBusr:V0ll3y@mysql.portlandvolleyball.org/pvaDB';
  $dbh = DB::connect($dsn);
  if (DB::isError($dbh)) {
    die($dbh->getMessage());
  }

  if ($_POST['delete'] == "true") {
    $dbh->query("DELETE FROM registration
          WHERE id = $id");
  }
  if ($_POST['deleteall'] == "true") {
    $dbh->query("DELETE FROM registration
          WHERE 1");
  }
  if ($_POST['paid'] == "true") {
    $dbh->query("update registration set paid = 1
          WHERE id = $id");
  }

  $count = $dbh->getAll("select count(*) from registration");

  $qry = $dbh->getAll("SELECT r.id, teamname, rl.name, mgrName, mgrPhone, mgrEmail, rl.night, rl2.name, rl2.night, r.paid
            FROM ((registration r left join registration_leagues rl on rl.id = r.league) left join registration_leagues rl2 on rl2.id = r.league2)
            ORDER BY rl.name, rl.night, teamname");


  if (!$qry) {
    echo "<div style=\"width: 750px; font-weight: bold; text-align: center; padding: 50px;\">There are no items to display.</div>";
  } else {
  foreach($count as $num) {
    $numRegistrations = $num[0];
  }
?>

    <h1>Registered Teams (<?php echo $numRegistrations?>)</h1>

    <table cellpadding="6" cellspacing="0" width="750" class="eventTable">
      <tr>
        <th>Team Name</th>
        <th>League</th>
        <th>2nd Choice League</th>
        <th>Manager</th>
        <th>Phone</th>
        <th>Email</th>
        <th>&nbsp;</th>
      </tr>

    <?php
      foreach ($qry as $result) {
      $paid = $result[9];
      $paidstring = $paid ? '<span style="color: #009900; font-weight: bold;">Paid</span>' : '<span style="color: #990000; font-weight: bold;">Not Paid</span>';
      echo"
      <tr>
        <td nowrap valign=\"top\"><a href=\"registration_detail.php?id=$result[0]\">$result[1]</a><br/>$paidstring</td>
        <td nowrap>$result[2] $result[6]</td>
        <td nowrap>$result[7] $result[8]&nbsp;</td>
        <td valign=\"top\">$result[3]</td>
        <td valign=\"top\">$result[4]</td>
        <td valign=\"top\">$result[5]</td>
        <td nowrap=\"nowrap\">";

        if(!$paid){
          $teamname = str_replace("'", "\'", $result[1]);
          echo"
          <form method=\"post\">
            <input type=\"submit\" value=\"Mark as paid\" />
            <input type=\"hidden\" name=\"id\" value=\"$result[0]\" />
            <input type=\"hidden\" name=\"paid\" value=\"true\" />
          </form>";
        }
       echo"
        <form method=\"post\" onclick=\"javascript: return confirm('Really delete this registration?');\">
          <input type=\"submit\" value=\"Delete\" />
          <input type=\"hidden\" name=\"id\" value=\"$result[0]\" />
          <input type=\"hidden\" name=\"delete\" value=\"true\" />
        </form>
        </td>
      </tr>";

      }
    ?>
    </table>

  <p>
    <form method="post" onclick="javascript: return confirm('This can not be undone!  Are you sure you want to delete all registrations?');">
      <input type="submit" value="Delete all registrations" />
      <input type="hidden" name="deleteall" value="true" />
    </form>
  </p>
<?php
}
?>
</body>
</html>