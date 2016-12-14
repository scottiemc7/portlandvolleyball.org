<?php

include("header.html");
include '../lib/mysql.php';

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

print <<<EOF
<h1>Add new home page article</h1>

<p>You can now add a column and priority to each story.  Stories in column 1 will go on the left; column 2 stories go in the box on the right.  Higher priority stories will show up at the top of the page; lower priority stories show up toward the bottom.  If two stories have the same priority, the newer story will appear first.</p>
EOF;
	
if($_POST['delete'] == "yes") {
  if(isset($_POST['id'])) { 
    $id=preg_replace('/[^\d]/','',$_POST['id']); 

    if(! dbquery("DELETE FROM home_page where id=$id")) {
      $error=dberror();
      print "***ERROR*** dbquery: Failed query<br />$error\n";
      exit;
    }
  }
}	
	
if ($_POST['title'] != "") {
  $title = str_replace("'", "&#39;", $_POST['title']);
  $article = str_replace("'", "&#39;", $_POST['article']);
  $column = $_POST['column'];
  $priority = $_POST['priority'];
  if(! dbquery("INSERT INTO home_page (title, article, storycolumn, priority) VALUES('$title', '$article', '$column', '$priority')")) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }
}

print <<<EOF
<form name="addEvent" class="eventForm" method="post">
	<table>
		<tr>
			<td>Title</td>
			<td><input type="text" name="title" size="40"></td>
		</tr>
		<tr>
			<td>Article</td>
			<td><textarea name="article" cols="60" rows="8"></textarea>
			<p>Note:  To stop spammers from collecting your email address, it's best to obscure
			it on the page.  You'll want to add it like the following (this is an example for info@portlandvolleyball.org).</p>
				<blockquote><small>&lt;script language="javascript"&gt;<br/>
				getMailto('info', 'portlandvolleyball.org')<br/>
				&lt;/script&gt;</small></blockquote>
			</td>
		</tr>
		<tr>
			<td>Column</td>
			<td>
				<select name="column">
					<option value="1">1</option>
					<option value="2">2</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Priority</td>
			<td>
				<select name="priority">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9" selected>9</option>
				</select> (9=highest, 1=lowest)
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" value="Add Article"></td>
		</tr>
	</table>			
</form>
EOF;

$sql=<<<EOF
SELECT id, title, article, storycolumn, priority
FROM home_page
ORDER BY priority desc, dtm DESC
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  if($row_cnt==0) {
    print "<div style=\"width: 750px; font-weight: bold; text-align: center;\">There are no items to display.</div>";
  }else{

    print <<<EOF
<h1>Current home page articles</h1>
<table cellpadding="6" cellspacing="0" width="750" class="eventTable">
	<tr>
		<th>Title</th>
		<th>Article</th>
		<th>Column</th>
		<th>Priority</th>
		<th>&nbsp;</th>
	</tr>

EOF;

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $title=$row['title'];
      $article=$row['article'];
      $storycolumn=$row['storycolumn'];
      $priority=$row['priority'];

      print <<<EOF
		<tr>
		<td valign="top">$tile</td>
		<td valign="top">$article</td>
		<td>$storycolumn</td>
		<td>$priority</td>
		<td>
		<form action="homepage_edit.php" method="post">
			<input type="submit" value="Edit" />
			<input type="hidden" name="id" value="$id" />
		</form>
		</td>
	</tr>
EOF;
    }

  }
  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

print <<<EOF
</table>
</body>
</html>
EOF;

dbclose();

?>
