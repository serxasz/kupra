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
	
	$recipe = mysql_fetch_row($recipes_result);

	// meniukas
	echo "
	<ol class=\"breadcrumb\">
	  <li><span class=\"glyphicon glyphicon-home\"></span><a href=\"/\"> Pradinis</a></li>
	  <li><a href=\"visi_receptai.php\">Receptai</a></li>
	  <li><a href=\"mano_receptai.php\">Mano receptai</a></li>
	  <li class=\"active\">$recipe[2]</li>
	</ol>";


	echo "<h2>Recepto redagavimas (Etapas 1 iš 2)</h2>";
	echo "<h3>Pagrindinė informacija</h3>";

	if (empty($_POST)) {
		echo "	<form action=\"redaguoti_recepta.php?edit=true&id=$editID\" method=\"post\">
						<div class=\"form-group\">
							<label for=\"name\" class=\"control-label\">Pavadinimas:</label>
							<input class=\"form-control\" type=\"text\" name=\"name\" value=\"$recipe[2]\">
						</div>
						<div class=\"form-group\">
							<label class=\"control-label\">Aprašymas:</label>
							<textarea class=\"form-control\" rows=\"8\" name=\"description\">$recipe[5]</textarea>
						</div>
						<div class=\"form-group\">
							<label for=\"duration\" class=\"control-label\">Gamybos trukmė:</label>
							<input class=\"form-control\" type=\"text\" name=\"duration\" value=\"$recipe[3]\">
						</div>
						<div class=\"form-group\">
							<label for=\"portions\" class=\"control-label\" >Porcijos:</label>
							<input class=\"form-control\" type=\"text\" name=\"portions\" value=\"$recipe[4]\">
						</div>

						<div class=\"form-group\">
							<label for=\"private\" class=\"control-label\">Privatus skelbimas:</label>
							<input type=\"checkbox\" name=\"private\" value=\"yes\" />
						</div>	

						<input class=\"form-control\" type=\"submit\" value=\"Išssaugoti.\">
				</form>";		
	} else {
		$name = $_POST["name"];
		$description = $_POST["description"];
		$portions = $_POST["portions"];
		$duration = $_POST["duration"];

		// Validation
			// Wrong format
			$minNameLength = 2;
			$maxNameLength = 20;

			$minDescLength = 2;
			$maxDescLength = 255;

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
				echo "Sėkmingai pakeista.";
			} else {
				die(mysql_error());
			}
		}

	echo 	"<br />
		  	 <br />
		  	 <a href=\"mano_receptai.php\">Pakeisti kitą</a>";
	}
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>