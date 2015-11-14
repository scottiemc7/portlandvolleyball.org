<?php

include("header.html");
include '../lib/mysql.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

$id=preg_replace('/[^\d]/','',$_POST['id']);
if ($_POST['delete'] == "true") {
  if(! dbquery("DELETE FROM registration WHERE id=$id")) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}	
if ($_POST['deleteall'] == "true") {
  if(! dbquery("DELETE FROM registration WHERE 1")) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}	
if ($_POST['paid'] == "true") {
  if(! dbquery("UPDATE registration SET paid=1 WHERE id=$id")) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}	
	
$count=0;
if($result=dbquery('SELECT COUNT(*) AS count FROM registration')) {
  $row=mysqli_fetch_assoc($result);
  $count=$row['count'];
  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}
	
$countPaid=0;
if($result=dbquery('SELECT COUNT(*) AS count FROM registration WHERE paid=1')) {
  $row=mysqli_fetch_assoc($result);
  $countPaid=$row['count'];
  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}
  
$sql=<<<EOF
SELECT r.id AS id, teamname, rl.name AS league1, mgrName, mgrPhone, mgrEmail, 
rl.night AS night1, rl2.name AS league2, rl2.night AS night2, r.paid AS paid, 
(select count(*) from team_members where teamid = r.id) as teammembers FROM 
((registration r left join registration_leagues rl on rl.id = r.league) 
left join registration_leagues rl2 on rl2.id = r.league2) 
ORDER BY rl.name, rl.night, teamname
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  if($row_cnt==0) {
    print <<<EOF
<div style="width: 750px; font-weight: bold; text-align: center; padding: 50px;">There are no items to display.</div>
EOF;
  }else{

    print <<<EOF
<h1>Registered Teams ($count total, $countPaid paid)</h1>
<p />
EOF;

    showSummary();

    print <<<EOF
<br style="clear: both;" />
<p />
<table cellpadding="6" cellspacing="0" width="750" class="eventTable">
<tr>
  <th>Team Name</th>
  <th>Roster submitted?</th>
  <th>League</th>
  <th>2nd Choice League</th>
  <th>Manager</th>
  <th>Phone</th>
  <th>Email</th>
  <th>&nbsp;</th>
</tr>
EOF;

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $teamname=$row['teamname'];
      $league1=$row['league1'];
      $mgrName=$row['mgrName'];
      $mgrPhone=$row['mgrPhone'];
      $mgrEmail=$row['mgrEmail'];
      $night1=$row['night1'];
      $league2=$row['league2'];
      $night2=$row['night2'];
      $paid=$row['paid'];
      $teammembers=$row['teammembers'];

      $paidstring = $paid ? '<span style="color: #009900; font-weight: bold;">Paid</span>' : '<span style="color: #990000; font-weight: bold;">Not Paid</span>';
      $rosterstring = ($teammembers < 1) ? "No" : $teammembers." players";
      print <<<EOF
<tr>
  <td nowrap valign="top"><a href="registration_detail.php?id=$id">$teamname</a><br/>$paidstring</td>
  <td>$rosterstring</td>
  <td nowrap>$league1 $night1</td>
  <td nowrap>$league2 $night2 &nbsp;</td>
  <td valign="top">$mgrName</td>
  <td valign="top">$mgrPhone</td>
  <td valign="top">$mgrEmail</td>
  <td nowrap="nowrap">
EOF;
        
      if(!$paid){
        $teamname = str_replace("'", "\'", $teamname);
        print <<<EOF
<form method="post">
  <input type="submit" value="Mark as paid" />
  <input type="hidden" name="id" value="$id" />
  <input type="hidden" name="paid" value="true" />
</form>
EOF;
      }

      print <<<EOF
<form method="post" onclick="javascript: return confirm('Really delete this registration?');">
  <input type="submit" value="Delete" />
  <input type="hidden" name="id" value="$id" />
  <input type="hidden" name="delete" value="true" />
</form>
</td>
</tr>
EOF;

    }

    print <<<EOF
</table>

<p>
<form method="post" onclick="javascript: return confirm('This can not be undone!  Are you sure you want to delete all registrations?');">
  <input type="submit" value="Delete all registrations" />
  <input type="hidden" name="deleteall" value="true" />
</form>
</p>

</body>
</html>
EOF;

  }

  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

dbclose();
  
/****************************************************************/

function showSummary() {

  $sql=<<<EOF
SELECT name, night, 
(SELECT count(*) FROM registration WHERE league=registration_leagues.id) AS registered, 
(SELECT count(*) FROM registration WHERE league=registration_leagues.id AND paid=1) AS paid 
FROM registration_leagues WHERE active = 1 ORDER BY name, night
EOF;

  if($result=dbquery($sql)) {

    print <<<EOF
<h3>Quick Summary:</h3>
<table cellpadding="6" cellspacing="0" class="eventTable">
<tr>
  <th>League</th>
  <th>Night of week</th>
  <th>Registered</th>
  <th>Paid</th>
</tr>

EOF;

    $iCounter = 0;
    while($row=mysqli_fetch_assoc($result)) {
      $name=$row['name'];
      $night=$row['night'];
      $registered=$row['registered'];
      $paid=$row['paid'];

      print <<<EOF
<tr>
  <td nowrap>$name</td>
  <td>$night</td>
  <td>$registered</td>
  <td>$paid</td>
</tr>
EOF;
    }

    print <<<EOF
</table>
EOF;

    mysqli_free_result($result);
  }else{
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}
						
?>
