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

		print_r($_POST);
		$sql = "INSERT INTO products (username, quantities_id, name, description, picture_path) VALUES ('$username', '$quantities', '$name','$description','$username')";

		if (mysql_query($sql)) {
			echo "Sėkmingai papildyta.";
		} else {
			echo mysql_error();
			echo "FAIL";
		}
	} else {
			echo '<table style=width:20%; text-align: center;>';

			echo '<form action="produktu_klasifikatorius.php" method="post">
					<tr>
						<td>Pavadinimas:</td>
						<td><input type="text" name="name"><td>
					</tr>';

			echo '<tr>
					<td>Vienetai:</td>
					<td><select name=vienetai>
	  					<option value="">Pasirinkti...</option>';

	  		$queryQuantities = "SELECT * FROM quantities";
			$quantities_result = mysql_query($queryQuantities);

			while($quantity = mysql_fetch_row($quantities_result)) { 
				echo "<option value=\"$quantity[0]\">$quantity[2]</option>";
			}
	  					
			echo '</select></td></tr>';

			echo '<tr>
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
				  </form>';
			echo '</table>';
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