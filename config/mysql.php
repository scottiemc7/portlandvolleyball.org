<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $host = '127.0.0.1';
    $username = 'root';
    $password = 'root';
    $dbname = 'pvaDB';
} else {
    $host = 'mysql.portlandvolleyball.org';
    $username = 'pvaDBusr';
    $password = 'ifGBO5wR5wQtJp3';
    $dbname = 'pvaDB';
}
