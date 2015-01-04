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
					<table style=width:20%; text-align: center;>
						<tr>
							<td>Pavadinimas:</td>
							<td><input type=\"text\" name=\"name\" value=\"$recipe[2]\"><td>
						</tr>
						<tr>
						<tr>
							<td>Aprašymas:</td>
							<td><input type=\"text\" name=\"description\" value=\"$recipe[5]\"'></td>
						</tr>
						<tr>
							<td>Gamybos trukmė:</td>
							<td><input type=\"text\" name=\"duration\" value=\"$recipe[3]\"></td>
						</tr>
						<tr>
							<td>Porcijos:</td>
							<td><input type=\"text\" name=\"portions\" value=\"$recipe[4]\"></td>
						</tr>
						<tr>
							<td>Nuotrauka</td>
							<td>...</td>
						</tr>
						<tr>
							<td>Privatus receptas:</td>
							<td><input type=\"checkbox\" name=\"private\" value=\"yes\" /></td>
					  	</tr>
					  	<tr>
						  	<td></td>
						  	<td><input type=\"submit\" value=\"Toliau.\"></td>
					  	</tr>	
					</table>
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