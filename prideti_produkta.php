<?php 
include('config.php');
$where = "naujas_produktas";
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
if (loggedIn($where)) {
	$username = $_SESSION['username'];

	// meniukas
	echo '
	<ol class="breadcrumb">
	  <li><span class="glyphicon glyphicon-home"></span><a href="/"> Pradinis</a></li>
	  <li><a href="produktu_klasifikatorius.php">Produktai</a></li>
	  <li class="active">Pridėti produktą</li>
	</ol>';

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
        
            $target_dir = "uploads/products/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $file_full_path = $target_dir . $_POST['name'] . "." . $imageFileType; 
                if(isset($_POST["fileToUpload"]) ) {
                            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                            if($check == false) {
                                $uploadOk = 0;
                                echo"Pasirinktas failas nėra paveikslėlis"; 
                                unset($_GET['action']);
                            }
                        }
                if (file_exists($target_file)) {
                    $uploadOk = 0;
                    echo"Toks failas jau egzistuoja"; 
                    unset($_GET['action']);
                }
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    $uploadOk = 0;
                    echo"Failas uzima per daug vietos"; 
                    unset($_GET['action']);
                }
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    $uploadOk = 0;
                    echo"Leidziami tik jpg, png ir gif failai"; 
                    unset($_GET['action']);
                }
            
                if ($uploadOk == 1 or !isset($_POST["fileToUpload"])) {
                    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_full_path);
                    $sql = "INSERT INTO products (username, 
                                                  quantities_id, 
                                                  name, 
                                                  description) VALUES ('$username',
																 '$quantities', 
																 '$name',
																 '$description')";
                    if (mysql_query($sql)) {
                        echo "Sėkmingai papildyta receptu \"$name\".";
                    }
                }
		}

		echo 	"<br />
			  	 <br />
			  	 <a href=\"prideti_produkta.php\">Įvesti kitą</a>";
	} else {
		echo    '<form action="prideti_produkta.php" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label for="name" class="control-label">Pavadinimas:</label>
							<input class="form-control" type="text" name="name">
						</div>
						
						<div class="form-group">
							<label class="control-label">Vienetai</label>
							<select class="form-control" name=vienetai>
			  					<option value="">Pasirinkti...</option>';

						  		$queryQuantities = "SELECT * FROM quantities";
								$quantities_result = mysql_query($queryQuantities);

								while($quantity = mysql_fetch_row($quantities_result)) { 
									echo "<option value=\"$quantity[0]\">$quantity[2]</option>";
								}
						  					
							echo '</select>
						</div>';

			echo 		'<div class="form-group">
							<label class="control-label">Aprašymas:</label>
							<textarea class="form-control" rows="8" name="description"></textarea>
						</div>
						
						<div class="form-group">
							<label class="control-label">Nuotrauka:</label>
							<input type="file" name="fileToUpload" id="fileToUpload">
						</div>

						<input class="form-control" type="submit" value="Sukurti">
				</form>';
	}
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>