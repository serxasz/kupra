<?php 
include('config.php');
$where = "naujas_receptas";
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
if (loggedIn($where)) {
	// meniukas
	echo '
	<ol class="breadcrumb">
	  <li><span class="glyphicon glyphicon-home"></span><a href="/"> Pradinis</a></li>
	  <li><a href="visi_receptai.php">Receptai</a></li>
	  <li class="active">Pridėti receptą</li>
	</ol>';
	
	if (!empty($_POST)) {
		
	}

	include('include_content/add_rcp.php');
	include('include_content/add_rcp2.php');

   	echo "<br /><br /><a href=\"receptai.php\">Atgal</a>";
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>