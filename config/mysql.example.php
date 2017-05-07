<?php

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
}