<?php

include("header.html");
include '../lib/mysql.php';

print <<<EOF
<h1>Edit ref</h1>
EOF;

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

$id=preg_replace('/[^\d]/','',$_POST['id']);

if($_POST['lname'] != "") {

  $uname=preg_replace('/[^a-zA-Z\d]/','',$_POST['uname']);
  $password=preg_replace('/[^a-zA-Z\d]/','',$_POST['password']);
  $fname=preg_replace('/[^a-zA-Z]/','',$_POST['fname']);
  $lname=preg_replace('/[^a-zA-Z]/','',$_POST['lname']);

  $sql=<<<EOF
UPDATE refs SET uname='$uname',password='$password',fname='$fname',lname ='$lname'
WHERE id=$id
EOF;

  if(!dbquery($sql)) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }

  print <<<EOF
This ref has been successfully edited. <a href="ref_add.php">return to list</a>
EOF;
}

$sql=<<<EOF
SELECT * FROM refs WHERE id=$id
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  if($row_cnt==0) {
    print <<<EOF
<div style="width: 750px; font-weight: bold; text-align: center;">There are no refs to display.</div>
EOF;
  }else{

    $row=mysqli_fetch_assoc($result);
    $uname=$row['uname'];
    $password=$row['password'];
    $fname=$row['fname'];
    $lname=$row['lname'];

    print <<<EOF
<form name="refEdit" class="eventForm" method="post">
<table>
  <tr>
    <td>First Name</td>
    <td><input type="text" name="fname" value="$fname" /></td>
  </tr>
  <tr>
    <td>Last Name</td>
    <td><input type="text" name="lname" value="$lname" /></td>
  </tr>
  <tr>
    <td>Username</td>
    <td><input type="text" name="uname" value="$uname" /></td>
  </tr>
  <tr>
    <td>Password</td>
    <td><input type="password" name="password" value="$password" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit_edit" value="Edit"></td>
  </tr>
</table>			
<input type="hidden" name="id" value="$id" />
</form>

<form action="ref_add.php" name="delete" style="margin-left: 70px;" method="post">
<p><b>Important:</b> Before deleting a ref, please make sure the ref isn't attached to any games.  
Otherwise, this could cause some things to look pretty funky.</p>
<input type="hidden" name="delete" value="yes" />
<input type="hidden" name="id" value="$id" />
<input type="submit" value="Delete this ref" onclick="javascript:return confirm('Really delete this ref?')">
</form>
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
