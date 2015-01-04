<?php 
include('config.php');
$where = "naujas_receptas";
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
if (loggedIn($where)) {
	$username = $_SESSION['username'];

	if (empty($_POST)) {
		// meniukas
		echo '
		<ol class="breadcrumb">
		  <li><span class="glyphicon glyphicon-home"></span><a href="/"> Pradinis</a></li>
		  <li><a href="visi_receptai.php">Receptai</a></li>
		  <li><a href="prideti_recepta.php">Pridėti receptą</a></li>
		  <li class="active">Etapas 2 iš 2</li>
		</ol>';

		echo "<h2>Naujo recepto kūrimas (Etapas 1 iš 2)</h2>";
		echo "<h3>Pagrindinė informacija</h3>";

		echo '	<form action="prideti_recepta.php" method="post">
					<table style=width:20%; text-align: center;>
						<tr>
							<td>Pavadinimas:</td>
							<td><input type="text" name="name"><td>
						</tr>
						<tr>
						<tr>
							<td>Aprašymas:</td>
							<td><input type="text" name="description"></td>
						</tr>
						<tr>
							<td>Gamybos trukmė:</td>
							<td><input type="text" name="duration"></td>
						</tr>
						<tr>
							<td>Porcijos:</td>
							<td><input type="text" name="portions"></td>
						</tr>
						<tr>
							<td>Nuotrauka</td>
							<td>...</td>
						</tr>
						<tr>
							<td>Privatus receptas:</td>
							<td><input type="checkbox" name="private" value="yes" /></td>
					  	</tr>
					  	<tr>
						  	<td></td>
						  	<td><input type="submit" value="Pereiti į antrą etapą."></td>
					  	</tr>	
					</table>
				</form>';		
	} else {
		$name = $_POST["name"];
		$description = $_POST["description"];
		$portions = $_POST["portions"];
		$duration = $_POST["duration"];
		$private = $_POST["private"];
		echo $private;
		if ($private == "yes") {
			$private = 1;
		}
		echo $private;

		// Validation
			// Wrong format
			$minNameLength = 2;
			$maxNameLength = 20;

			$minDescLength = 2;
			$maxDescLength = 255;

			// Duplicate
			$duplicate = false;

			$queryForName = "SELECT name FROM recipes WHERE (name='$name' AND username='$username')";
			$name_result = mysql_query($queryForName);

			if (mysql_num_rows($name_result) == 0) {
				$duplicate = false;
			} else {
				$duplicate = true;
			}


		if ( (strlen($name) < $minNameLength) or (strlen($name) > $maxNameLength) ) {
			echo "Leidžiamas recepto pavadinimo dydis yra nuo $minNameLength simbolių iki $maxNameLength";
		} else if ( (strlen($description) < $minDescLength) or (strlen($description) > $maxDescLength) ) {
			echo "Leidžiamas recepto aprašymo dydis yra nuo $minDescLength simbolių iki $maxDescLength";
		} else if ($duplicate) { 
			echo "Jūs jau esate sukūręs receptą su vardu \"$name\".";
		} else if (!is_numeric($portions)) {
			echo "Porcijų kiekis - \"$portions\" nėra leistinas kiekis. Naudokitės skaičiais [0-9].";
		} else if (!is_numeric($duration)) {
			echo "Gamybos trukmė - \"$duration\" nėra leistinas kiekis. Naudokitės skaičiais [0-9].";
		} else {
			$sql = "INSERT INTO recipes (username, name, description, portions, duration, private) VALUES ('$username','$name', '$description', '$portions', '$duration', '$private')";

			if (mysql_query($sql)) {
				// meniukas
				echo '
				<ol class="breadcrumb">
				  <li><span class="glyphicon glyphicon-home"></span><a href="/"> Pradinis</a></li>
				  <li><a href="visi_receptai.php">Receptai</a></li>
				  <li><a href="prideti_recepta.php">Pridėti receptą</a></li>
				  <li class="active">Etapas 1 iš 2</li>
				</ol>';

				echo "<h2>Naujo recepto kūrimas (Etapas 2 iš 2)</h2>";
				echo '<h3>Produktų pridėjimas</h3>';
				echo "<h4>$name produktai</h4>";

				$viewID = mysql_insert_id();

				echo '<div id="addProduct"><b>Šią vietą užpildys receptui priskirti produktai.<br /></b></div>';

				echo "<form>
						Produktų paieška: <input type=\"text\" onkeyup=\"showUser(this.value, $viewID)\">
					  </form>
						<br>
						<div id=\"txtHint\"><b>Rasti produktai bus rodomi šioje dalyje.</b></div>";
			}
		}
	}
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>