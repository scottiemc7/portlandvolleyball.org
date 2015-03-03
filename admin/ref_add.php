<?php

include("header.html");
include '/home/pva/portlandvolleyball.org/lib/mysql.php';

print <<<EOF
<h1>Add referee</h1>
EOF;

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}
	
if($_POST['delete'] == "yes") {
  $id=preg_replace('/[^\d]/','',$_POST['id']);
  if(!dbquery("DELETE FROM refs WHERE id=$id")) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}elseif($_POST['fname'] != "") {
  $uname=preg_replace('/[^a-zA-Z\d]/','',$_POST['uname']);
  $password=preg_replace('/[^a-zA-Z\d]/','',$_POST['password']);
  $fname=preg_replace('/[^a-zA-Z]/','',$_POST['fname']);
  $lname=preg_replace('/[^a-zA-Z]/','',$_POST['lname']);

  $sql=<<<EOF
INSERT INTO refs(uname, password, fname, lname) 
VALUES('$uname', '$password', '$fname', '$lname')
EOF;
  if(!dbquery($sql)) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}
	
print <<<EOF
<form action="ref_add.php" name="addRef" class="eventForm" method="post">
<table>
  <tr>
    <td>First Name</td>
    <td><input type="text" name="fname" value="" size="40"></td>
  </tr>
  <tr>
    <td>Last Name</td>
    <td><input type="text" name="lname" value="" size="40"></td>
  </tr>
  <tr>
    <td>Username (Allowed characters: a-z, A-Z, 0-9)</td>
    <td><input type="text" name="uname" value="" size="40"></td>
  </tr>
  <tr>
    <td>Password (Allowed characters: a-z, A-Z, 0-9)</td>
    <td><input type="password" name="password" value="" size="40"></td>
  </tr>
  <tr>
    <td colspan="2">Supply the username and password to the referee. 
    The referee will use these to login to enter scores.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="Add Ref"></td>
  </tr>
</table>			
</form>
EOF;

$sql=<<<EOF
SELECT id, lname, fname FROM refs ORDER BY lname
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  if($row_cnt==0) {
    print <<<EOF
<div style="width: 750px; font-weight: bold; text-align: center;">There are no refs to display.</div>
EOF;
  }else{

    print <<<EOF
<h1>Current refs</h1>
<table cellpadding="6" cellspacing="0" width="750" class="eventTable">
  <tr>
    <th>Name</th>
    <th>&nbsp;</th>
  </tr>
EOF;

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $uname=$row['uname'];
      $password=$row['password'];
      $fname=$row['fname'];
      $lname=$row['lname'];

      print <<<EOF
  <tr>
    <td valign="top">$lname, $fname</td>
    <td>
      <form action="ref_edit.php" method="post">
        <input type="submit" value="Edit" />
        <input type="hidden" name="id" value="$id" />
      </form>
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
