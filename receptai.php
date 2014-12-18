<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[81]; 
if (loggedIn($where)) {

    echo "<h1>Receptai</h1>";
    echo "<a href=\"prideti_recepta.php\">Pridėti receptą</a><br />";
    echo "<a href=\"visi_receptai.php\">Visų receptų sąrašas</a><br />";
    echo "<a href=\"mano_receptai.php\">Mano receptų sąrašas</a><br />";
	echo "<br /><br /><a href=\"index.php\">Atgal</a><br />";


} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>