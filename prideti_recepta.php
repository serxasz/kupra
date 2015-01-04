<?php 
include('config.php');
$where = "naujas_receptas";
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
if (loggedIn($where)) {
	$username = $_SESSION['username'];

	if (empty($_POST) & empty($_GET)) {
		// meniukas
		echo '
		<ol class="breadcrumb">
		  <li><span class="glyphicon glyphicon-home"></span><a href="/"> Pradinis</a></li>
		  <li><a href="visi_receptai.php">Receptai</a></li>
		  <li><a href="prideti_recepta.php">Pridėti receptą</a></li>
		  <li class="active">Etapas 1 iš 2</li>
		</ol>';

		echo '<div class="">';
		echo "<h2>Naujo recepto kūrimas (Etapas 1 iš 2)</h2>";
		echo "<h3>Pagrindinė informacija</h3>";

		echo '
			<form action="prideti_recepta.php" method="post">
						<div class="form-group">
							<label for="name" class="control-label">Pavadinimas:</label>
							<input class="form-control" type="text" name="name">
						</div>
						<div class="form-group">
							<label class="control-label">Aprašymas:</label>
							<textarea class="form-control" rows="8" name="description"></textarea>
						</div>
						<div class="form-group">
							<label for="duration" class="control-label">Gamybos trukmė:</label>
							<input class="form-control" type="text" name="duration">
						</div>
						<div class="form-group">
							<label for="portions" class="control-label">Porcijos:</label>
							<input class="form-control" type="text" name="portions">
						</div>
						<div class="form-group">
							<label for="photo" class="control-label">Nuotrauka:</label>
						</div>

						<div class="form-group">
							<label for="private" class="control-label">Privatus skelbimas:</label>
							<input type="checkbox" name="private" value="yes" />
						</div>						

						<input class="form-control" type="submit" value="Pereiti į antrą etapą.">	
				</form><br /><br /><br /><br /></div>';		
	} else if (empty($_GET)) {
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
				  <li class="active">Etapas 2 iš 2</li>
				</ol>';

				echo "<h2>Naujo recepto kūrimas (Etapas 2 iš 2)</h2>";
				echo '<h3>Produktų pridėjimas</h3>';

				echo '<div class="col-md-6">';
				echo "<h4>Recepto '$name' produktai</h4>";

				echo '<div id="addProduct"><b>Šią vietą užpildys receptui priskirti produktai.<br /></b></div>';
				echo '</div>';

				echo '<div class="col-md-6">
						<h4>Produktų paieška</h4>';

				$viewID = mysql_insert_id();
				echo "<form>
						Ieškoti: <input type=\"text\" onkeyup=\"showUser(this.value, $viewID)\">
					  </form>
						<br>
						<div id=\"txtHint\">";
				echo "<script>showUser('', $viewID)</script>";
				echo   "</div>
						</div>";
				echo '<form action="prideti_recepta.php" method="post">';
			}
		}
	} else {
		echo "rodom kita psl";
	}
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>