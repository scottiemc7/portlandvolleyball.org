<?php
// Test
if ($_SERVER['SERVER_PORT'] == 8001) {
  $host = '127.0.0.1';
  $username='root';
  $password='root';
  $dbname='pva_test';
// Development
} else if ($_SERVER['SERVER_PORT'] == 8000) {
  $host = '127.0.0.1';
  $username='root';
  $password='root';
  $dbname='pvaDB';
// Production
} else {
  $host = 'mysql.portlandvolleyball.org';
  $username='pvaDBusr';
  $password='ifGBO5wR5wQtJp3';
  $dbname='pvaDB';
}