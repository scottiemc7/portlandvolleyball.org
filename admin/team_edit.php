<?php

require_once '../lib/mysql.php';
include 'header.html.php';

print <<<EOF
<h1>Edit team</h1>
EOF;

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

if(isset($_POST['id'])) { 
  $id=preg_replace('/[^\d]/','',$_POST['id']); 
}
	
if($_POST['name'] != "") {
  $name = dbescape($_POST['name']);
  $league=preg_replace('/[^\d]/','',$_POST['league']); 

  $sql=<<<EOF
UPDATE teams SET name='$name',league=$league WHERE id=$id
EOF;

  if(! dbquery($sql)) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }else{
    print "This team has been successfully edited. <a href=\"team_add.php\">return to list</a>";
  }

}

$leagues=getLeagues(1);

$sql=<<<EOF
SELECT * FROM teams WHERE id=$id
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  if($row_cnt > 0) {

    $row=mysqli_fetch_assoc($result);
    $id=$row['id'];
    $name=$row['name'];
    $league=$row['league'];

    print <<<EOF
<form name="addTeam" class="eventForm" method="post">
<table>
<tr>
  <td>Team name:</td>
  <td><input type="text" name="name" value="$name"></td>
</tr>
<tr>
  <td>League:</td>
  <td><select name="league">
    <option value="> -- Select -- </option>
EOF;

    foreach($leagues as $key=>$val) {
      $selected="";
      if($val == $league) {
        $selected=' selected="selected"';
      }

      print <<<EOF
<option value="$val"$selected>$key</option>
EOF;
    }

    print <<<EOF
     </select>
   </td>
</tr>
<tr>
  <td>&nbsp;</td>
  <input type="hidden" name="id" value="$id">
  <td><input type="submit" value="Edit Team"></td>
</tr>
</table>
</form>

<form action="team_add.php" name="delete" style="margin-left: 70px;" method="post">
<p><b>Important:</b> Before deleting a team, please make sure there are no games in 
the database for that team.  Otherwise, things are going to look pretty screwy on the schedules page.</p>
	<input type="hidden" name="delete" value="yes">
	<input type="hidden" name="id" value="$id">
	<input type="submit" value="Delete this team" onclick="javascript:return confirm('Really delete this team?')">
</form>
EOF;

  }else{
    print "<div style=\"width: 750px; font-weight: bold; text-align: center;\">Team not found.</div>";
  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

print <<<EOF
</body>
</html>
EOF;

dbclose();

/****************************************************************/
// $leagues=getLeagues($active);

function getLeagues($active) {
  $leagues=array();

  if(isset($active) && is_numeric($active) && $active!=1) {
    $active=0;
  }

  $sql="SELECT * FROM leagues WHERE active=$active ORDER BY name";

  if($result=dbquery($sql)) {

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $name=$row['name'];

      $leagues[$name]=$id;
    }
  
    mysqli_free_result($result);
  }else{
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }

  return($leagues);
}

?>


