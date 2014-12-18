<?php
	$username = $_SESSION['username'];

	echo "<h2>Naujas receptas</h2>";

	if (empty($_POST)) {
		echo '	<form action="receptai.php" method="post">
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
						  	<td><input type="submit" value="Sukurti"></td>
					  	</tr>	
					</table>
				</form>';		
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
			$sql = "INSERT INTO recipes (username, name, description, portions, duration) VALUES ('$username','$name', '$description', '$portions', '$duration')";

			if (mysql_query($sql)) {
				echo "Sėkmingai papildyta.";
			}
		}

	echo 	"<br />
		  	 <br />
		  	 <a href=\"receptai.php\">Įvesti kitą</a>";
	}
   	?>