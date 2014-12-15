<?php 

/*******************/

$mysql_hostname = "localhost"; 
$mysql_user = "kupra_db";
$mysql_password = "123456";
$mysql_database = "kupra_db";
mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or trigger_error("Unable to connect to the database: " . mysql_error()); 
mysql_select_db($mysql_database) or trigger_error("Unable to switch to the database: " . mysql_error()); 

/*******************/

$publickey = "6Le3rf4SAAAAAA5JBaF8zkXQaaYwSXnBOg-7YtoD"; // for recaptcha
$privatekey = "6Le3rf4SAAAAAGIMq73Aa198SmMqFxeZxSq4HPBR"; // for recaptcha
$title = "Kupra"; // title of page
$admin = "Admin"; // Administrators username
$adress = "kupra.us.lt"; // adress of site
$email_verification = 1; // 1 - on; 0 - off.
$default_language = 'locale/LT.php'; // choose default language
$spam_time = 10; // time to wait for next action
$max_pm = 100;

/*******************/

session_start();
$_SESSION['error'] = "";	

/*******************/

include('includes/cron_jobs.php'); 
include('includes/functions.php');

/*******************/

?>