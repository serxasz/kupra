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
			<form action="prideti_recepta.php" method="post" enctype="multipart/form-data">
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
							<label for="photo" class="control-label">Nuotraukos:</label>
                            <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
						</div>

						<div class="form-group">
							<label for="private" class="control-label">Privatus skelbimas:</label>
							<input type="checkbox" name="private" value="yes" />
						</div>						

						<input class="form-control" type="submit" value="Sukurti receptą ir pereiti į antrą etapą">	
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
			$maxNameLength = 40;

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
            
            $valid_formats = array("jpg", "png", "gif", "jpeg");
            $max_file_size = 1024*100; //100 kb
            $path = "uploads/recipes/".$name."/"; // Upload directory
            mkdir($path, 0777);
            $count = 0;

            if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
            // Loop $_FILES to exeicute all files
            foreach ($_FILES['files']['name'] as $f => $namex) {     
            if ($_FILES['files']['error'][$f] == 4) {
                continue; // Skip file if any error found
            }	       
            if ($_FILES['files']['error'][$f] == 0) {	           
                if ($_FILES['files']['size'][$f] > $max_file_size) {
                    $message[] = "$namex is too large!.";
                    continue; // Skip large files
	        }
			elseif( ! in_array(pathinfo($namex, PATHINFO_EXTENSION), $valid_formats) ){
				$message[] = "$name is not a valid format";
				continue; // Skip invalid file formats
			}
	        else{ // No error found! Move uploaded files 
	            if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$namex))
	            $count++; // Number of successfully uploaded file
                rename($path.$namex, $path.$count.".".pathinfo($namex, PATHINFO_EXTENSION));
	        }
	    }
	}
}
            
			$sql = "INSERT INTO recipes (username, name, description, portions, duration, private) VALUES ('$username','$name', '$description', '$portions', '$duration', '$private')";

			mysql_query($sql);
			$viewID = mysql_insert_id();

			$sql2 = "INSERT INTO ratings (recipe_name, rating, hits) VALUES ('$name', 0, 0)";
			if ( mysql_query($sql2) ) {

				// meniukas
				echo '
				<ol class="breadcrumb">
				  <li><span class="glyphicon glyphicon-home"></span><a href="/"> Pradinis</a></li>
				  <li><a href="visi_receptai.php">Receptai</a></li>
				  <li><a href="prideti_recepta.php">Pridėti receptą</a></li>';
				 echo "
				  <li><a href=\"visi_receptai.php?view=$viewID\">$name</a></li>";
				 echo'
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

				echo "DEBUG <br /> MYSQL INSERT ID === $viewID";
				echo "<form>
						Ieškoti: <input type=\"text\" onkeyup=\"showUser(this.value, $viewID)\">
					  </form>
						<br>
						<div id=\"txtHint\">";
				echo "<script>showUser('', $viewID)</script>";
				echo   "</div>
						</div>";
				/*echo '
				<form action="prideti_recepta.php" method="post">
				<input class="form-control" type="submit" value="Sukurti receptą">';*/
			}
		}
	}
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>