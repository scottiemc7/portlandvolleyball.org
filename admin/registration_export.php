<?php
/**************
This PHP script Extracts MySQL table and downloads into an Excel Spreadsheet.
Script by Jeff Johns, for a full explanation and tutorial on this, see: http://www.phpfreaks.com/tutorials/114/0.php
**************
CONFIGURATION:

YOUR DATABASE HOST = (ex. localhost)
USERNAME = username used to connect to host
PASSWORD = password used to connect to host
DB_NAME = your database name
TABLE_NAME = table in the database used for extraction
**************
To extract specific fields and not the whole table, simply replace
the * in the $select variable with the fields you want
**************/
define(db_host, "mysql.portlandvolleyball.org");
define(db_user, "pvaDBusr");
define(db_pass, "V0ll3y");
define(db_link, mysql_connect(db_host,db_user,db_pass));
define(db_name, "pvaDB");
mysql_select_db(db_name);
/*************
Build query, call it, and find the number of fields
/*************/
$select = "SELECT TeamName, rl.name, rl.night, mgrName, mgrPhone, mgrPhone2, mgrEmail, mgrEmail2, altName, altPhone, altPhone2, altEmail as League, addr1, addr2, city, state, zip FROM 'registration' r join registration_leagues rl on rl.id = r.league";
$export = mysql_query($select);
$count = mysql_num_fields($export);
/************
Extract field names and write them to the $header variable
/***********/
for ($i = 0; $i < $count; $i++) {
$header .= mysql_field_name($export, $i)."t";
}
/***********
Extract all data, format it, and assign to the $data variable
/**********/
while($row = mysql_fetch_row($export)) {
$line = '';
foreach($row as $value) {
if ((!isset($value)) OR ($value == "")) {
$value = "t";
} else {
$value = str_replace('"', '""', $value);
$value = '"' . $value . '"' . "t";
}
$line .= $value;
}
$data .= trim($line)."n";
}
$data = str_replace("r", "", $data);
/************
Set the default message for zero records
/************/
if ($data == "") {
$data = "n(0) Records Found!n";
}
/************
Set the automatic download section
/************/
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=spreadsheet.xls");
header("Pragma: no-cache");
header("Expires: 0″);
print "$headern$data";
?>