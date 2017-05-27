<?php
// Test

if ($_SERVER['SERVER_PORT'] == 8001) {
  $host = '127.0.0.1';
  $username='root';
  $password='';
  $dbname='pva_test';
// Development
} else if ($_SERVER['SERVER_PORT'] == 8000) {
  $host = '127.0.0.1';
  $username='root';
  $password='';
  $dbname='pvaDB';
}