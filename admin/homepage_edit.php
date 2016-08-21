<?php

include("header.html");
include '../lib/mysql.php';

  print <<<EOF
<h1>Edit article</h1>
EOF;

$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

if(isset($_POST['id'])) {
  $id=preg_replace('/[^\d]/','',$_POST['id']);
}

if ($_POST['title'] != "") {
  $title = dbescape($_POST['title']);
  $article = dbescape($_POST['article']);
  $column = preg_replace('/[^\d]/','',$_POST['column']);
  $priority = preg_replace('/[^\d]/','',$_POST['priority']);

  $sql=<<<EOF
UPDATE home_page SET title='$title', article='$article', storycolumn='$column', priority=$priority  WHERE id=$id
EOF;

  if(! dbquery($sql)) {
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }

  print <<<EOF
<p>This article has been successfully edited.  <a href="homepage_add.php">return to list</a></p>
EOF;
}

$sql=<<<EOF
SELECT id, title, article, storycolumn, priority FROM home_page WHERE id=$id
EOF;

if($result=dbquery($sql)) {

  $row_cnt=mysqli_num_rows($result);
  if($row_cnt==0) {
    print <<<EOF
<div style="width: 750px; font-weight: bold; text-align: center;">There are no events to display.</div>
EOF;
  }else{

    while($row=mysqli_fetch_assoc($result)) {
      $id=$row['id'];
      $title=htmlentities($row['title']);
      $article=htmlentities($row['article']);
      $storycolumn=$row['storycolumn'];
      $priority=$row['priority'];

      print <<<EOF
<form name="edit" class="eventForm" method="post">
  <table>

    <tr>
      <td>Title</td>
      <td><input type="text" name="title" value="$title" size="40"></td>
    </tr>
    <tr>
      <td valign="top">Article</td>
      <td><textarea name="article" cols="60" rows="8">$article</textarea>
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
        <input type="text" name="column" value="$storycolumn" />
      </td>
    </tr>
    <tr>
      <td>Priority</td>
      <td>
        <input type="text" name="priority" value="$priority" /> (9=highest, 1=lowest)
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" value="Edit"/></td>
    </tr>
  </table>
  <input type="hidden" name="id" value="$id">
</form><br/>

<form action="homepage_add.php" name="delete" method="post" style="margin-left: 70px;">
  <input type="hidden" name="delete" value="yes" />
  <input type="hidden" name="id" value="$id" />
  <input type="submit" value="Delete this article" onclick="javascript:return confirm('Really delete this article?')" />
</form>
EOF;
    }

  }
  mysqli_free_result($result);
}else{
  $error=dberror();
  print "***ERROR*** dbquery: Failed query<br />$error\n";
  exit;
}

dbclose();

?>
</body>
</html>


