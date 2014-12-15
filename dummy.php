<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[81]; 
if (loggedIn($where)) {
	
}else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>