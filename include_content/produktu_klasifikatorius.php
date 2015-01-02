<?php 
include('config.php');
$where = "produktai";
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
if (loggedIn($where)) {

	$username = $_SESSION['username'];

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
			  	 <a href=\"produktu_klasifikatorius.php\">Įvesti kitą</a>";
	} else {
		echo    '<form action="produktu_klasifikatorius.php" method="post" enctype="multipart/form-data">
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
							<textarea class="form-control" rows="3" name="description"></textarea>
						</div>
						
						<div class="form-group">
							<label class="control-label">Nuotrauka:</label>
							<input type="file" name="fileToUpload" id="fileToUpload">
						</div>

						<input class="form-control" type="submit" value="Sukurti">
				</form>';
	}

	echo "<h2>Produktų sąrašas</h2>";

	// Pagination 
		// Total number of rows in table
			$query = "SELECT COUNT(*) as num FROM products";
			$total_pages = mysql_fetch_array(mysql_query($query));
			$total_pages = $total_pages[num];

		// sorter
		$limitForForm = $_GET['limit'];
		if ($limitForForm == 10) {
			$select10 = 'selected';
		} elseif ($limitForForm == 25) {
			$select25 = 'selected';
		} elseif ($limitForForm == 50) {
			$select50 = 'selected';
		} else {
			$select10 = 'selected';
		}
		echo "<form>Viso įrašų: $total_pages. Puslapyje rodyti po: 
		<select name=\"limit\" onchange=\"this.form.submit()\">';
			<option $select10 value=\"10\">10</option>
			<option $select25 value=\"25\">25</option>
			<option $select50 value=\"50\">50</option>
		</select>
		<noscript><input type=\"submit\" value=\"Submit\"></noscript>
		</form>";
		echo '<br />';

		/* Setup vars for query. */
			$targetpage = "produktu_klasifikatorius.php"; 	//your file name  (the name of this file)
			$limit = 10; 									//how many items to show per page

			$customLimit = $_GET['limit'];
			if (isset($customLimit) & $customLimit != $limit) {
				$limit = $customLimit;
				$customLimit = "&limit=$customLimit";
			}

			$page = $_GET['page'];

			if ($page) 
				$start = ($page - 1) * $limit; 			//first item to display on this page
			else
				$start = 0;								//if no page var is given, set start to 0



	$queryProducts = "SELECT * FROM products LIMIT $start, $limit";
	$products_result = mysql_query($queryProducts);

	echo "<table class=\"table table-bordered table-striped\" style=\"width:20%; text-align: center;\">
		<thead>
		  	<tr>
		  		<th>ID</th>
		    	<th>Produktas</th>
		    	<th>Aprašymas</th>
		    	<th>Vienetai</th>
                <th>Nuotrauka</th>
	  	  	</tr>
        </thead>
        <tbody>";
    $file = glob("uploads/products/*.{jpg,jpeg,png,gif}",GLOB_BRACE);

	while($product = mysql_fetch_row($products_result)) {
		$sql = "SELECT name FROM quantities WHERE id='$product[2]'";
		$result = mysql_query($sql);
		$quantity = mysql_fetch_row($result);
        
        $image = "";
        foreach ($file as $i) {
            if ($i == "uploads/products/" . $product[3] . ".jpg" or $i == "uploads/products/" . $product[3] . ".jpeg" or $i == "uploads/products/" . $product[3] . ".png" or $i == "uploads/products/" . $product[3] . ".gif") {
                        $image = '<img src="'.$i.'" alt="photo" height="75" width="75">';
                    }
                }

       	echo "<tr>
       			<td>$product[0]</td>
       			<td>$product[3]</td>
       			<td>$product[4]</td>
       			<td>$quantity[0]</td>
                <td>$image</td>
       		  </tr>";
   	}

	echo "</tbody></table>";

	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/

	include('include_content/pagination.php');

   	echo "<br /><br /><a href=\"index.php\">Atgal</a>";
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>