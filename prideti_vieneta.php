<?php 
include('config.php');
$where = "naujas_vienetas"; 
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);

if (loggedIn($where)) {
	$username = $_SESSION['username'];

	// meniukas
	echo '
	<ol class="breadcrumb">
	  <li><span class="glyphicon glyphicon-home"></span><a href="/"> Pradinis</a></li>
	  <li><a href="/vnt_klasifikatorius.php">Vienetai</a></li>
	  <li class="active">Pridėti vienetą</li>
	</ol>';

	echo "<h2>Pridėti vienetą</h2>";

	if (!empty($_POST)) {
		$newQuantityName = $_POST['quantity'];

		// Validation
			// Wrong format
			$minQuantityLength = 2;
			$maxQuantityLength = 20;

			if ( (strlen($newQuantityName) < $minQuantityLength) or (strlen($newQuantityName) > $maxQuantityLength) ) {
				$wrongFormat = true;
			} else {
				$wrongFormat = false;
			}

			// Duplicate
			$duplicate = false;

			$queryQuantities = "SELECT name FROM quantities";

			$quantities_result = mysql_query($queryQuantities);

			while($quantity = mysql_fetch_row($quantities_result)) {
				if ($quantity[0] == $newQuantityName) {
					$duplicate = true;
					break;
				}
			}

			if ($duplicate) {
				echo "Vienetas su vardu \"$newQuantityName\" jau egzistuoja.";
			} else if ($wrongFormat) {
				echo "Leidžiamas vieneto pavadinimo dydis yra nuo $minQuantityLength simbolių iki $maxQuantityLength";
			} else {
				$sql = "INSERT INTO quantities (username, name) VALUES ('$username', '$newQuantityName')";

				if (mysql_query($sql)) {
					echo "Sėkmingai papildyta \"$newQuantityName\" vienetu.";
				}
			}

			echo 	"<br />
				  	 <br />
				  	 <a href=\"vnt_klasifikatorius.php\">Įvesti kitą</a>";
	} else {
		echo 	'<form class="form-inline" action="vnt_klasifikatorius.php" method="post">
					<div class="form-group">
					 <label class="control-label" for="quantity">Pavadinimas</label>
					 <input class="form-control" placeholder="" type="text" name="quantity">
					</div>
					<button type="submit" class="btn btn-default">Pridėti</button>
				 </form>';
	}
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>