<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[81]; 
if (loggedIn($where)) {

	$username = $_SESSION['username'];

	echo "<h2>Naujas produktas</h2>";
	
	if (!empty($_POST)) {
		$name = $_POST["name"];
		$description = $_POST["description"];
		$quantities = $_POST["vienetai"];

		// Validation
			// Wrong format
			$minNameLength = 2;
			$maxNameLength = 20;

			$minDescLength = 2;
			$maxDescLength = 255;

			// Duplicate
			$duplicate = false;

			$queryForName = "SELECT name FROM products WHERE name='$name'";
			$name_result = mysql_query($queryForName);

			if (mysql_num_rows($name_result) == 0) {
				$duplicate = false;
			} else {
				$duplicate = true;
			}

			// No quantities selection
			$noSelection = false;

			if ($quantities == "") {
				$noSelection = true;
			}


		if ( (strlen($name) < $minNameLength) or (strlen($name) > $maxNameLength) ) {
			echo "Leidžiamas produkto pavadinimo dydis yra nuo $minNameLength simbolių iki $maxNameLength";
		} else if ( (strlen($description) < $minDescLength) or (strlen($description) > $maxDescLength) ) {
			echo "Leidžiamas produkto aprašymo dydis yra nuo $minDescLength simbolių iki $maxDescLength";
		} else if ($duplicate) { 
			echo "Produktas su vardu \"$name\" jau egzistuoja.";
		} else if ($noSelection) {
			echo "Matavimo vienetas privalo būti pasirinktas.";
		} else {

			$sql = "INSERT INTO products (username, 
										  quantities_id, 
										  name, 
										  description, 
										  picture_path) VALUES ('$username',
																 '$quantities', 
																 '$name',
																 '$description',
																 '')";
			if (mysql_query($sql)) {
				echo "Sėkmingai papildyta receptu \"$name\".";
			}
		}

		echo 	"<br />
	  	 <br />
	  	 <a href=\"produktu_klasifikatorius.php\">Įvesti kitą</a>";
	} else {
			echo '<form action="produktu_klasifikatorius.php" method="post">
					<table style=width:20%; text-align: center;>
						<tr>
							<td>Pavadinimas:</td>
							<td><input type="text" name="name"><td>
						</tr>
						<tr>
							<td>Vienetai:</td>
							<td><select name=vienetai>
	  					<option value="">Pasirinkti...</option>';

				  		$queryQuantities = "SELECT * FROM quantities";
						$quantities_result = mysql_query($queryQuantities);

						while($quantity = mysql_fetch_row($quantities_result)) { 
							echo "<option value=\"$quantity[0]\">$quantity[2]</option>";
						}
				  					
						echo '</select></td></tr>';

			echo 		'<tr>
							<td>Aprašymas:</td>
							<td><input type="text" name="description"></td>
						</tr>
						<tr>
							<td>Nuotrauka:</td>
							<td>...</td>
						</tr>
						<tr>
						  	<td></td>
						  	<td><input type="submit" value="Sukurti"></td>
						</tr>
					</table>
				</form>';
	}

	echo "<h2>Produktų sąrašas</h2>";

	$queryProducts = "SELECT * FROM products";
	$products_result = mysql_query($queryProducts);

	echo "<table style=\"width:20%; text-align: center;\">
		  	<tr>
		  		<th>ID</th>
		  		<th>Nuotrauka</th>
		    	<th>Produktas</th>
		    	<th>Aprašymas</th>
		    	<th>Vienetai</th>
	  	  	</tr>";

	while($product = mysql_fetch_row($products_result)) {
		$sql = "SELECT name FROM quantities WHERE id='$product[2]'";
		$result = mysql_query($sql);
		$quantity = mysql_fetch_row($result);

       	echo "<tr>
       			<td>$product[0]</td>
       			<td>...</td>
       			<td>$product[3]</td>
       			<td>$product[4]</td>
       			<td>$quantity[0]</td>
       		  </tr>";
   	}

	echo "</table>";

   	echo "<br /><br /><a href=\"index.php\">Atgal</a>";

} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>