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
	</ol>
	
	 <table  style="background: rgba(245,245,245,0.7);width: 50%" class="table table-bordered" align="center" >';

	echo "<h2>Pridėti vienetą</h2>";

	if (!empty($_POST)) {
		$newQuantityName = $_POST['quantity'];

		// Validation
			// Wrong format
			$minQuantityLength = 2;
			$maxQuantityLength = 25;

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
				  	 <a href=\"prideti_vieneta.php\">Įvesti kitą</a>";
	} else {
		echo 	'<form class="form-inline" action="prideti_vieneta.php" method="post">
					<div class="form-group">
					<tr> <td>
				<center>	 <label class="control-label" for="quantity">Pavadinimas</label></center>
					  </td></tr>
					 <tr> <td>
					<center> <input class="form-control" placeholder="" type="text" name="quantity"></center>
					   </td></tr>
					</div>
					<tr> <td>
					<center><button type="submit" class="btn btn-default" style=";width: 50%">Pridėti</button></center>
					 </td></tr>
				 </form>';
	}
	echo '</table>';
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>