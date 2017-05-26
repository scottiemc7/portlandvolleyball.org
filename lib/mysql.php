<?php
$errorlevel=error_reporting();
error_reporting($errorlevel & ~E_NOTICE);
static $mysql="";

function dbinit() {
  global $mysql;
  $error="";

  $filename = $_SERVER['DOCUMENT_ROOT'] . '/config/mysql.php';

  if (file_exists($filename)) {
    // Production
    require $_SERVER['DOCUMENT_ROOT'] . '/config/mysql.php';

  } else if ($_SERVER['SERVER_PORT'] == 8001) {
    // Tests
    define(MYSQL_HOST,'127.0.0.1');
    define(MYSQL_USERNAME,'root');
    define(MYSQL_PASSWORD,'root');
    define(MYSQL_DBNAME,'pva_test');

  } else if ($_SERVER['SERVER_PORT'] == 8000) {

    // Development
    define(MYSQL_HOST,'127.0.0.1');
    define(MYSQL_USERNAME,'root');
    define(MYSQL_PASSWORD,'root');
    define(MYSQL_DBNAME,'pvaDB');
  } else {
    die('Cannot find MySQL credentials. Use mysql.example.php to create a credentials file in config/mysql.php');
  }

  $mysql=new mysqli(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DBNAME);


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
