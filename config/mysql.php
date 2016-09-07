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
} else if ($_SERVER['SERVER_NAME'] == 'pva.joshuabremer.com') {
  $host = 'localhost';
  $username='stingeyb_pva';
  $password='C]Xt8dgKM73eG&';
  $dbname='stingeyb_pva';

} else {
  $host = 'mysql.portlandvolleyball.org';
  $username='pvaDBusr';
  $password='ifGBO5wR5wQtJp3';
  $dbname='pvaDB';
}