<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[81]; 
if (loggedIn($where)) {
	$username = $_SESSION['username'];

	echo "<h2>Naujas vienetas</h2>";
	
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
		echo 	'<form action="vnt_klasifikatorius.php" method="post">
					Pavadinimas: <input type="text" name="quantity">
					<input type="submit" value="Papildyti">
				 </form>';
	}

	echo "<h2>Matavimo vienetai</h2>";

	$queryQuantities = "SELECT * FROM quantities";
	$quantities_result = mysql_query($queryQuantities);

	echo "<table style=\"width:20%; text-align: center;\">
		  	<tr>
		    	<th>Vienetas</th> 
	  	  	</tr>";

	while($quantity = mysql_fetch_row($quantities_result)) {
       	echo "<tr>
       			<td>$quantity[2]</td>
       		  </tr>";
   	}
	echo "</table>";

   	echo "<br /><br /><a href=\"index.php\">Atgal</a>";

} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>