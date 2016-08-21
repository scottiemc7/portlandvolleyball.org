<?php

include("header.html");
include '../lib/mysql.php';

$req=array_merge($_GET,$_POST);

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

if(isset($req['submit'])) {
  $submit=$req['submit'];
  if(strcasecmp($submit,"Add")==0) {

    list($status,$id,$title,$description,$date,$time,$link)=Process($req);
    if($status == "") {
      if(! dbquery("INSERT INTO events (title,description,dt,tm,link) VALUES ('$title','$description','$date','$time','$link')")) {
        $error=dberror();
        print "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
      }
    }else{
      Error($status);
    }

  }elseif(strcasecmp($submit,"Edit")==0) {

    if(isset($req['id'])) {
      $id=preg_replace('/[^\d]/','',$req['id']);
      if(! is_numeric($id)) {
        Error("Invalid ID");
      }
    }else{
      Error("No ID specified");
    }

    $sql=<<<EOF
SELECT id,title,description,DATE_FORMAT(dt,'%m/%d/%Y') AS dt,TIME_FORMAT(tm,'%H:%i') AS tm,link
FROM events WHERE id=$id
EOF;

    if($result=dbquery($sql)) {

      $row_cnt=mysqli_num_rows($result);
      if($row_cnt==0) {
        Error("Event ($id) deleted.");
      }else{

        print "<h1>Edit event</h1>\n";
        if($row=mysqli_fetch_assoc($result)) {
    $id=$row['id'];
    $title=$row['title'];
    $description=$row['description'];
    $dt=$row['dt'];
    $tm=$row['tm'];
    $link=$row['link'];

          Form($id,$title,$description,$dt,$tm,$link);
        }
  exit;

      }

      mysqli_free_result($result);
    }else{
      $error=dberror();
      print "***ERROR*** dbquery: Failed query<br />$error\n";
      exit;
    }

  }elseif(strcasecmp($submit,"Save changes")==0) {

    if(isset($req['id'])) {
      $id=preg_replace('/[^\d]/','',$req['id']);
      if(! is_numeric($id)) {
        Error("Invalid ID");
      }
    }else{
      Error("No ID specified");
    }

    list($status,$id,$title,$description,$date,$time,$link)=Process($req);
    if($status == "") {
      if(! dbquery("UPDATE events SET title='$title', description='$description', dt='$dt', tm='$tm', link='$link' WHERE id=$id")) {
        $error=dberror();
        print "***ERROR*** dbquery: Failed query<br />$error\n";
        exit;
      }
    }else{
      Error($status);
    }

  }elseif(strcasecmp($submit,"Delete this event")==0) {

    if(isset($req['id'])) {
      $id=preg_replace('/[^\d]/','',$req['id']);
      if(! is_numeric($id)) {
        Error("Invalid ID");
      }
    }else{
      Error("No ID specified");
    }

    if(! dbquery("DELETE FROM events WHERE id=$id")) {
      $error=dberror();
      print "***ERROR*** dbquery: Failed query<br />$error\n";
      exit;
    }
  }else{
    Error("Invalid submit");
  }
}

print "<h1>Add a new event</h1>\n";
Form("","","","","","");
ShowAll();

dbclose();

/**
*** Show all events
**/

function ShowAll() {

  $sql=<<<EOF
SELECT id,title,description,DATE_FORMAT(dt,'%m/%d/%Y'),TIME_FORMAT(tm,'%H:%i'),link
FROM events ORDER BY dt, tm ASC
EOF;

  if($result=dbquery($sql)) {

    $row_cnt=mysqli_num_rows($result);
    if($row_cnt==0) {
      Error("There are no events to display");
    }else{

      print <<<EOF
<h1>Existing Events</h1>
<table cellpadding="6" cellspacing="0" width="750" class="eventTable">
  <tr><th>Date/Time</th><th>Title</th><th>Description</th><th>&nbsp;</th></tr>
EOF;

      while($row=mysqli_fetch_assoc($result)) {
  $id=$row['id'];
  $title=$row['title'];
  $description=$row['description'];
  $dt=$row['dt'];
  $tm=$row['tm'];
  $link=$row['link'];

  if(! empty($link)) {
    $description.="<br /><a href=\"$link\">More information</a>";
  }

        print <<<EOF
  <tr><td nowrap valign="top">$dt<br />$tm</td>
      <td valign="top">$title</td>
      <td valign="top">$description</td>
      <td>
        <form method="post">
        <input type="submit" name="submit" value="Edit">
        <input type="hidden" name="id" value="$id">
        </form>
      </td></tr>
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

}

/**
*** Event form
**/

function Form($id,$title,$desc,$dt,$tm,$link) {
    print <<<EOF
<form class="eventForm" method="post">
EOF;

  if(isset($id) && ctype_digit($id)) {
    print <<<EOF
<input type="hidden" name="id" value="$id">
EOF;
  }

  print <<<EOF
<table>
<tr><td>Date</td><td><input type="text" name="date" value="$dt" /></td></tr>
<tr><td>Time</td><td><input type="text" name="time" value="$tm" /></td></tr>
<tr><td>Title</td><td><input type="text" name="title" value="$title" /></td></tr>
<tr><td>Description</td><td><textarea name="description" cols="35" rows="3">$desc</textarea></td></tr>
<tr><td>Link</td><td><input type="text" name="link" value="$link" /></td></tr>
EOF;

  if(isset($id) && ctype_digit($id)) {
    print <<<EOF
<tr><td>&nbsp;</td><td><input type="submit" name="submit" value="Save changes" /></td></tr>
EOF;
  }else{
    print <<<EOF
<tr><td>&nbsp;</td><td><input type="submit" name="submit" value="Add" /></td></tr>
EOF;
  }

  print <<<EOF
</table>
</form>
EOF;

  if(isset($id) && ctype_digit($id)) {
    print <<<EOF
<form method="post" style="margin-left: 70px;">
<input type="hidden" name="id" value="$id" />
<input type="submit" name="submit" value="Delete this event" onclick="javascript:return confirm('Really delete this event?')" />
</form>
EOF;
  }
}

/**
*** Process submitted form
***
*U* list($status,$id,$title,$description,$date,$time,$link)=Process($req);
**/

function Process($req) {
  $status="";
  $id="";
  $title="";
  $description="";
  $date="";
  $time="";
  $link="";

  if(isset($req['id']) && ctype_digit($req['id'])) {
    $id=$req['id'];
  }

  if(isset($req['title']) && ($req['title'] != "")) {
    $title = ereg_replace("'", "&#39", $req['title']);
  }else{
    $status.="No title specified<br />";
  }

  if(isset($req['description']) && ($req['description'] != "")) {
    $description = ereg_replace("'", "&#39", $req['description']);
  }else{
    $status.="No description specified<br />";
  }

  if(isset($req['date']) && ($req['date'] != "")) {
    $dt_array = explode('/', $req['date']);
    if(checkdate($dt_array[0], $dt_array[1], $dt_array[2])) {
      $date=$dt_array[2] . '-' . $dt_array[0] . '-' . $dt_array[1];
    }else{
      $status.="Invalid date. Must be MM/DD/YYYY<br />";
    }
  }else{
    $status.="No date specified<br />";
  }

  if(isset($req['time']) && ($req['time'] != "")) {
    $time=$req['time'];
  }else{
    $status.="No time specified<br />";
  }

  if(isset($req['link']) && ($req['link'] != "")) {
    $link=$req['link'];
  }

  return array($status,$id,$title,$description,$date,$time,$link);
}

/**
*** Display error message
**/

function Error($txt) {
  print <<<EOF
<p />
<font color="#ff0000">ERROR:</font> $txt
<p />

EOF;
  exit;
}

?>

</body>
</html>


