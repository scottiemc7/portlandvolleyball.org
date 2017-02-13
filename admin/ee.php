<?php include 'header.html.php'; ?>

<?php

require 'DB.php';
$dsn = 'mysql://pvaDBusr:V0ll3y@mysql.portlandvolleyball.org/pvaDB';
$dbh = DB::connect($dsn);
if (DB::isError($dbh)) {
  die($dbh->getMessage());
}

$req=array_merge($_GET,$_POST);

if(isset($req['submit'])) {
  $submit=$req['submit'];
  if(strcasecmp($submit,"Add")==0) {

    list($status,$id,$title,$description,$date,$time,$link)=Process($req);
    if($status == "") {
      $status = $dbh->query("INSERT INTO events (title,description,dt,tm,link) VALUES ('$title','$description','$date','$time','$link')");
      if(DB::isError($status)) {
        Error($status->getMessage());
      }
    }else{
      Error($status);
    }

  }elseif(strcasecmp($submit,"Edit")==0) {

    if(isset($req['id'])) {
      $id=$req['id'];
    }else{
      Error("No ID specified");
    }
	
    $qry = $dbh->getAll("SELECT id,title,description,DATE_FORMAT(dt,'%m/%d/%Y'),TIME_FORMAT(tm,'%H:%i'),link  FROM events WHERE id = $id");
    if(!$qry) { 
      Error("Event ($id) deleted.");
    }else{
      print "<h1>Edit event</h1>\n";
      foreach ($qry as $result) {
        Form($result[0],$result[1],$result[2],$result[3],$result[4],$result[5]);
      }
      exit;
    }

  }elseif(strcasecmp($submit,"Save changes")==0) {

    if(isset($req['id'])) {
      $id=$req['id'];
    }else{
      Error("No ID specified");
    }

    list($status,$id,$title,$description,$date,$time,$link)=Process($req);
    if($status == "") {
      $sql_array = array($title, $description, $date, $time, $link, $id);
      $status = $dbh->query("UPDATE events SET title = ?, description = ?, dt = ?, tm = ?, link = ? WHERE id = ?", $sql_array);
      if(DB::isError($status)) {
        Error($status->getMessage());
      }
    }else{
      Error($status);
    }

  }elseif(strcasecmp($submit,"Delete this event")==0) {

    if(isset($req['id'])) {
      $id=$req['id'];
    }else{
      Error("No ID specified");
    }

    $qry = $dbh->query("DELETE FROM events WHERE id = $id");
    if(!$qry) {
      Error("Event ($id) already deleted.");
    }
  }else{
    Error("Invalid submit");
  }
}

print "<h1>Add a new event</h1>\n";
Form("","","","","","");
ShowAll($dbh);
	
/**
*** Show all events
**/

function ShowAll($dbh) {
  $qry = $dbh->getAll("SELECT id,title,description,DATE_FORMAT(dt,'%m/%d/%Y'),TIME_FORMAT(tm,'%H:%i'),link FROM events ORDER BY dt, tm ASC");
  if(!$qry) {
    Error("There are no events to display");
  }else{

    print <<<EOF
<h1>Existing Events</h1>
<table cellpadding="6" cellspacing="0" width="750" class="eventTable">
  <tr><th>Date/Time</th><th>Title</th><th>Description</th><th>&nbsp;</th></tr>
EOF;
   foreach($qry as $result) {
     $desc=$result[2];
     if($result[5] != "") {
       $desc.="<br /><a href=\"$result[5]\">More information</a>";
     }
    print <<<EOF
  <tr><td nowrap valign="top">$result[3]<br />$result[4]</td>
      <td valign="top">$result[1]</td>
      <td valign="top">$desc</td>
      <td>
        <form method="post">
        <input type="submit" name="submit" value="Edit">
        <input type="hidden" name="id" value="$result[0]">
        </form>
      </td></tr>
EOF;
    }
    print <<<EOF
</table>
EOF;
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


