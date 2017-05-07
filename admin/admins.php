<?php

require_once '../lib/mysql.php';
include 'header.html.php';

print <<<EOF
<h1>Add Admin</h1>
EOF;

function checkPassword($pwd) {
    $password_errors = [];

    if (strlen($pwd) < 8) {
        $password_errors[] = "Password too short!";
    }

    if (!preg_match("#[0-9]+#", $pwd)) {
        $password_errors[] = "Password must include at least one number!";
    }

    if (!preg_match("#[a-zA-Z]+#", $pwd)) {
        $password_errors[] = "Password must include at least one letter!";
    }

    return $password_errors;
}

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

if($_POST['uname'] != "") {
  $uname=$_POST['uname'];
  $password=md5($_POST['password']);
  $password_errors = checkPassword($_POST['password']);
  if (count($password_errors) !== 0) {
    echo "<p class='error'>" . implode("<br>",$password_errors) . "</p>";
  } else {
    $sql=<<<EOF
INSERT INTO admins(username, password)
VALUES('$uname', '$password')
EOF;
    if(!dbquery($sql)) {
      $error=dberror();
      print "***ERROR*** dbquery: Failed query<br />$error\n";
      exit;
    }
  }
}
?>

<form action="admins.php" name="add_admin" class="eventForm" method="post">
<table>
  <tr>
    <td>Username</td>
    <td><input type="text" name="uname" value="" size="40"></td>
  </tr>
  <tr>
    <td>Password</td>
    <td><input type="password" name="password" value="" size="40"></td>
  </tr>
  <tr>
    <td colspan="2">Supply the username and password to the admin.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="Add Admin"></td>
  </tr>
</table>
</form>

<?php
$sql=<<<EOF
SELECT username from admins ORDER BY username
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  if($row_cnt==0) {
    print <<<EOF
<div style="width: 750px; font-weight: bold; text-align: center;">Something is wrong with your query. No admins were returned.</div>
EOF;
  }else{

    print <<<EOF
<h1>portlandvolleyball.org Administrators</h1>
<table cellpadding="6" cellspacing="0" width="750" class="eventTable admins-table">
  <tr>
    <th>Username</th>
    <th>&nbsp;</th>
  </tr>
EOF;

    while($row=mysqli_fetch_assoc($result)) {
      $username=$row['username'];

      print <<<EOF
  <tr class="admins-table__row">
    <td valign="top">$username</td>
    <td>
    </td>
  </tr>
EOF;
    }

    print <<<EOF
</table>
EOF;

  }
  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

dbclose();

print <<<EOF
</body>
</html>
EOF;

?>
