<?php
$errorlevel=error_reporting();
error_reporting($errorlevel & ~E_NOTICE);
static $mysql="";

function dbinit() {
  global $mysql;
  $error="";

  require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql.php';
  $mysql=new mysqli($host,$username,$password,$dbname);


  if(!$mysql) {
    $error= "dbinit: Cannot connect (Error #" . mysqli_connect_errno() .
            ") " . mysqli_connect_error();
  }

  return $error;
}

function dbquery($sql) {
  global $mysql;
  $result=mysqli_query($mysql,$sql);
  return $result;
}

function dbclose() {
  global $mysql;
  if(!empty($mysql)) {
    mysqli_close($mysql);
  }
}

function dberror() {
  global $mysql;
  return mysqli_errno($mysql) . ": " . mysqli_error($mysql);
}

function dbinfo() {
  global $mysql;
  $str="Server version: " . mysqli_get_server_info($mysql) . "\n";
  $str.="Client version: " . mysqli_get_client_info() . "\n";
  return $str;
}

function dbescape($str) {
  global $mysql;
  return mysqli_real_escape_string($mysql,$str);
}

function dbinsertid() {
  global $mysql;
  return mysqli_insert_id($mysql);
}

?>
