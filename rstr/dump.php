<?php 

require_once 'lib/mysql.php';
include '../header.html.php'; 



$error=dbinit();
if($error!=="") {
  print "***ERROR*** dbinit: $error\n";
  exit;
}

if(isset($_GET["t"]) and ( ! empty($_GET["t"]))) {
  
  $table=$_GET["t"];

  $sql=<<<EOF
SELECT * FROM $table
EOF;

  if($result=dbquery($sql)) {

    $row_cnt=mysqli_num_rows($result);

    if($row_cnt == 0) {
      print <<<EOF
<div style="width: 750px; font-weight: bold; text-align: center; padding: 50px;">There are no items to display.</div>
EOF;
    }else{

      print <<<EOF
<table border="1">
EOF;

      $first=1;
      while($row=mysqli_fetch_assoc($result)) {
        //ksort($row);
        if($first==1) {
          print "<tr>";
	  foreach ($row as $key => $value) {
	    print "<th>$key</th>";
	  }
          print "</tr>\n";
          $first=0;
        }
        print "<tr>";
        foreach ($row as $key => $value) {
	  if(strcmp($value,"") == 0) {
	    $value="&nbsp;";
	  }
          print "<td>$value</td>";
        }
        print "</tr>\n";
      }
  
      mysqli_free_result($result);

      print <<<EOF
</table>
EOF;
    }

  }else{
    $error=dberror();
    print "***ERROR*** dbquery: Failed query<br />$error\n";
    exit;
  }

}else{
  print <<<EOF
<div style="width: 750px; font-weight: bold; text-align: center; padding: 50px;">No table specified.</div>
EOF;
}

dbclose();

?>

</body>
</html>
