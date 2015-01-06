<?php 
include('config.php');
$where = "redaguoti_recepta";
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
if (loggedIn($where)) {

	$username = $_SESSION['username'];

	$editID = $_GET["id"];

	$queryRecipes = "SELECT * FROM recipes WHERE username='$username' AND id='$editID'";
		
	$recipes_result = mysql_query($queryRecipes);
	
	if( !(isAdministrator($username)) and (mysql_num_rows($recipes_result) <= 0) ) { 
		echo "Klaida.";
	} else {
	$queryRecipes = "SELECT * FROM recipes WHERE id='$editID'";
		
	$recipes_result = mysql_query($queryRecipes);

	$recipe = mysql_fetch_row($recipes_result);

	if (empty($_POST)) {
	// meniukas
	echo "
	<ol class=\"breadcrumb\">
	  <li><span class=\"glyphicon glyphicon-home\"></span><a href=\"/\"> Pradinis</a></li>
	  <li><a href=\"visi_receptai.php\">Receptai</a></li>
	  <li><a href=\"mano_receptai.php\">Mano receptai</a></li>
	  <li><a href=\"visi_receptai.php?view=$recipe[0]\">$recipe[2]</a></li>
	  <li class=\"active\">$recipe[2]</li>
	</ol>";


	echo "<h2>Recepto redagavimas (Etapas 1 iš 2)</h2>";
	echo "<h3>Pagrindinė informacija</h3>";

	echo "	<form action=\"redaguoti_recepta.php?edit=true&id=$editID\" method=\"post\">
					<div class=\"form-group\">
						<label for=\"name\" class=\"control-label\">Pavadinimas</label>
						<input class=\"form-control\" type=\"text\" name=\"name\" value=\"$recipe[2]\">
					</div>
					<div class=\"form-group\">
						<label class=\"control-label\">Aprašymas</label>
						<textarea class=\"form-control\" rows=\"8\" name=\"description\">$recipe[5]</textarea>
					</div>
					<div class=\"form-group\">
						<label for=\"duration\" class=\"control-label\"><span class=\"glyphicon glyphicon glyphicon-time\"></span> Gamybos trukmė (minutėmis)</label>
						<input class=\"form-control\" type=\"text\" name=\"duration\" value=\"$recipe[4]\">
					</div>
					<div class=\"form-group\">
						<label for=\"portions\" class=\"control-label\" ><span class=\"glyphicon glyphicon glyphicon-adjust\"></span> Porcijos</label>
						<input class=\"form-control\" type=\"text\" name=\"portions\" value=\"$recipe[3]\">
					</div>

					<div class=\"form-group\">
						<label for=\"private\" class=\"control-label\">Privatus skelbimas</label>
						<input type=\"checkbox\" name=\"private\" value=\"yes\" />
					</div>	

					<input class=\"form-control\" type=\"submit\" value=\"Baigta. Pereiti į Etapą 2\">
			</form>";		
	} else {
		$name = $_POST["name"];
		$description = $_POST["description"];
		$portions = $_POST["portions"];
		$duration = $_POST["duration"];

		// Validation
			// Wrong format
			$minNameLength = 2;
			$maxNameLength = 40;

			$minDescLength = 2;
			$maxDescLength = 20000;

		if ( (strlen($name) < $minNameLength) or (strlen($name) > $maxNameLength) ) {
			echo "Leidžiamas recepto pavadinimo dydis yra nuo $minNameLength simbolių iki $maxNameLength";
		} else if ( (strlen($description) < $minDescLength) or (strlen($description) > $maxDescLength) ) {
			echo "Leidžiamas recepto aprašymo dydis yra nuo $minDescLength simbolių iki $maxDescLength";
		} else if (!is_numeric($portions)) {
			echo "Porcijų kiekis - \"$portions\" nėra leistinas kiekis. Naudokitės skaičiais [0-9].";
		} else if (!is_numeric($duration)) {
			echo "Gamybos trukmė - \"$duration\" nėra leistinas kiekis. Naudokitės skaičiais [0-9].";
		} else {
			$sql = "UPDATE recipes SET username='$username', name='$name', description='$description', portions='$portions', duration='$duration' WHERE id='$editID'";

			if (mysql_query($sql)) {
				// meniukas
				echo "
				<ol class=\"breadcrumb\">
				  <li><span class=\"glyphicon glyphicon-home\"></span><a href=\"/\"> Pradinis</a></li>
				  <li><a href=\"visi_receptai.php\">Receptai</a></li>
				  <li><a href=\"mano_receptai.php\">Mano receptai</a></li>
				  <li><a href=\"visi_receptai.php?view=$recipe[0]\">$name</a></li>
				  <li class=\"active\">Etapas 2 iš 2</li>
				</ol>";

				echo "<h2>Recepto redagavimas (Etapas 2 iš 2)</h2>";
				echo '<h3>Produktų pridėjimas</h3>';

				echo '<div class="col-md-6">';
				echo "<h4>Recepto '$name' produktai</h4>";


					echo "<div id=\"addProduct\">";

					// get list of products
				    $viewID = $editID;
				   	$queryProducts = "SELECT * FROM recipe_products WHERE recipe_id='$viewID'";
					$products = mysql_query($queryProducts);

					if(mysql_num_rows($products) > 0) { 
						echo "<table class=\"table table-bordered table-striped\" style=\"width:20%; text-align: center;\">
							  	<tr>
							  		<th></th>
							  		<th></th>
							  		<th>Produktas</th>
							    	<th>Vienetas</th>
							    	<th>Kiekis</th>
						  	  	</tr>";
					} else {
					}

					$numeracija = 0;
					while ($product = mysql_fetch_row($products)) {
						$queryProductInfo = "SELECT * FROM products WHERE id='$product[2]'";
						$result_productInfo = mysql_query($queryProductInfo);
						$productInfo = mysql_fetch_row($result_productInfo);

						$queryQuantityInfo = "SELECT name FROM quantities WHERE id='$productInfo[2]'";
						$result_quantityInfo = mysql_query($queryQuantityInfo);
						$quantityInfo = mysql_fetch_row($result_quantityInfo);		
				        
				        $file = glob("uploads/products/*.{jpg,jpeg,png,gif}",GLOB_BRACE);
				        $image = "";
				        foreach ($file as $i) {
				            if ($i == "uploads/products/" . $productInfo[3] . ".jpg" 
				            	or 
				            	$i == "uploads/products/" . $productInfo[3] . ".jpeg" 
				            	or $i == "uploads/products/" . $productInfo[3] . ".png" 
				            	or $i == "uploads/products/" . $productInfo[3] . ".gif") {
				                        $image = '<img src="'.$i.'" alt="photo" height="75" width="75">';
				            }
				        }
				       	$numeracija++;

							    echo 	"<tr>
							    			<td>$numeracija</td>
							    			<td>$image</td>
							       			<td>$productInfo[3]</td>
							       			<td>$quantityInfo[0]</td>
							       			<td><input type=\"text\" value=\"$product[3]\" size=\"5\" onchange=\"productAddition(this.value, $productInfo[0], $editID)\"></td>
							       		</tr>";
					}

					if(mysql_num_rows($products) > 0) { 
						echo "</table>";
					} else {
						echo '<b>Šią vietą užpildys receptui priskirti produktai.</b>';
					}
					echo "</div>";
				echo '</div>';

				echo '<div class="col-md-6">
						<h4>Produktų paieška</h4>';

				echo "<form>
						Ieškoti: <input type=\"text\" onkeyup=\"showUser(this.value, $editID)\">
					  </form>
						<br>
						<div id=\"txtHint\">";
				echo "<script>showUser('', $editID)</script>";
				echo   "</div>
						</div>";

				echo "<a href=\"redaguoti_recepta.php?edit=true&id=$editID\">Grįžti į Etapą 1 (Pagrindinė informacija)</a><br /><br />";
				echo "<a class=\"form-control\" href=\"visi_receptai.php?view=$recipe[0]\">Išsaugoti</a>";
			} else {
				die(mysql_error());
			}
		}
	}
}
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>