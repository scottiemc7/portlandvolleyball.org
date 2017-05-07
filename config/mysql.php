<?php
// Test

if ($_SERVER['SERVER_PORT'] == 8001) {
  define(MYSQL_HOST,'127.0.0.1');
  define(MYSQL_USERNAME,'root');
  define(MYSQL_PASSWORD,'');
  define(MYSQL_DBNAME,'pva_test');
// Development
} else if ($_SERVER['SERVER_PORT'] == 8000) {
  define(MYSQL_HOST,'127.0.0.1');
  define(MYSQL_USERNAME,'root');
  define(MYSQL_PASSWORD,'');
  define(MYSQL_DBNAME,'pvaDB');
// Production
} else if ($_SERVER['SERVER_NAME'] == 'pva.joshuabremer.com') {
  define(MYSQL_HOST,'localhost');
  define(MYSQL_USERNAME,'stingeyb_pva');
  define(MYSQL_PASSWORD,'C]Xt8dgKM73eG&');
  define(MYSQL_DBNAME,'stingeyb_pva');

} else {
  define(MYSQL_HOST,'mysql.portlandvolleyball.org');
  define(MYSQL_USERNAME,'pvaDBusr');
  define(MYSQL_PASSWORD,'ifGBO5wR5wQtJp3');
  define(MYSQL_DBNAME,'pvaDB');
}