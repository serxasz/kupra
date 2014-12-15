<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$username = $_SESSION['username'];
$administrator = isAdministrator($username);
if (loggedIn($where) && isAdministrator($username)) {

	if (!empty($_POST)) {
		$id = $_POST["id"];
		$name = $_POST["name"];
		$qID = $_POST["vienetai"];

			$queryEdit = "UPDATE products SET name='$name', quantities_id='$qID' WHERE id='$id'";
			mysql_query($queryEdit);

			echo mysql_error();

		echo "Pakeitimai išsaugoti.";
	}	

	if (!empty($_GET['edit'])) {
		$editingID = $_GET['edit'];

	} elseif (!empty($_GET['delete'])) {
		$id = $_GET['delete'];

			$queryDelete = "DELETE FROM products WHERE id=$id";
			mysql_query($queryDelete);
	}

	echo "<h2>Produktai</h2>";

	$queryGetProducts = "SELECT * FROM products";
	$products_result = mysql_query($queryGetProducts); 

	echo "<table style=\"width:55%; text-align: center;\">
		  	<tr>
		    	<th>Kurėjas</th>
		    	<th>Produktas</th>
		    	<th>Vienetas</th>
		    	<th>Panaudota (trūksta rcp)</th>
		    	<th></th>
	  	  	</tr>";

	while($product = mysql_fetch_row($products_result)) {
		$panaudota_kartu = 0;

		if ($panaudota_kartu == 0) {
			$controls = "<a href=\"edit_products.php?edit=$product[0]\">Redaguoti</a>
						 <a href=\"edit_products.php?delete=$product[0]\">Ištrinti</a>";
		} else {
			$controls = "";
		}

		$sql = "SELECT name FROM quantities WHERE id='$product[2]'";
		$result = mysql_query($sql);
		$quantity = mysql_fetch_row($result);

		if (!($product[0] == $editingID)) {
			echo "<tr>
			 	<td>$product[1]</td>
		    	<td>$product[4]</td>
		    	<td>$quantity[0]</td>
		    	<td>$panaudota_kartu</td>
		    	<td>$controls</td>
			 </tr>";
		} else {
   			echo "<form action=\"edit_products.php\" method=\"post\">
   				 	<tr>
					 	<td>$product[1]</td>
				    	<td><input type=\"text\" name=\"name\" value=\"$product[4]\"></td>
						<td>
							<select name=vienetai>
		  					<option value=\"$product[2]\">$quantity[0]</option>";

					  		$queryQuantities = "SELECT * FROM quantities";
							$quantities_result = mysql_query($queryQuantities);

							while($quantity = mysql_fetch_row($quantities_result)) { 
								if ($quantity[0] != $product[2] ) {
									echo "<option value=\"$quantity[0]\">$quantity[2]</option>";
								}
							}

			echo "			</select>
						</td>
				    	<td>$panaudota_kartu</td>
				    	<td>
				    		<input type=\"hidden\" name=\"id\" value=\"$product[0]\">
				    		<input type=\"submit\" value=\"Išsaugoti\">
				    	</td>
				 	</tr>
				 </form>";
		}
	}

	echo "</table>";

	echo "<br /><br /><a href=\"admin.php\">Atgal</a>";

} else {
include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>