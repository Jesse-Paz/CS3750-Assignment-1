<?php
define('DBSERVER', 'localhost');
define('DBUSERNAME', 'DATABASE');
define('DBPASSWORD', 'DATABASE');
define('DBNAME', 'CS3750ONE');

$db = mssql_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD);
mssql_select_db($DBNAME);

if($db === false){
	die("Failed to connect to server");
}
