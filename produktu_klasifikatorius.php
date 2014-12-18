<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[81]; 
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

			$sql = "INSERT INTO products (username, 
										  quantities_id, 
										  name, 
										  description, 
										  picture_path) VALUES ('$username',
																 '$quantities', 
																 '$name',
																 '$description',
																 '')";
			if (mysql_query($sql)) {
				echo "Sėkmingai papildyta receptu \"$name\".";
			}
		}

		echo 	"<br />
	  	 <br />
	  	 <a href=\"produktu_klasifikatorius.php\">Įvesti kitą</a>";
	} else {
			echo '<form action="produktu_klasifikatorius.php" method="post">
					<table style=width:20%; text-align: center;>
						<tr>
							<td>Pavadinimas:</td>
							<td><input type="text" name="name"><td>
						</tr>
						<tr>
							<td>Vienetai:</td>
							<td><select name=vienetai>
	  					<option value="">Pasirinkti...</option>';

				  		$queryQuantities = "SELECT * FROM quantities";
						$quantities_result = mysql_query($queryQuantities);

						while($quantity = mysql_fetch_row($quantities_result)) { 
							echo "<option value=\"$quantity[0]\">$quantity[2]</option>";
						}
				  					
						echo '</select></td></tr>';

			echo 		'<tr>
							<td>Aprašymas:</td>
							<td><input type="text" name="description"></td>
						</tr>
						<tr>
							<td>Nuotrauka:</td>
							<td>...</td>
						</tr>
						<tr>
						  	<td></td>
						  	<td><input type="submit" value="Sukurti"></td>
						</tr>
					</table>
				</form>';
	}

	echo "<h2>Produktų sąrašas</h2>";

	// Pagination 
		// Total number of rows in table
			$query = "SELECT COUNT(*) as num FROM products";
			$total_pages = mysql_fetch_array(mysql_query($query));
			$total_pages = $total_pages[num];
			echo "Viso įrašų: $total_pages";

		/* Setup vars for query. */
			$targetpage = "produktu_klasifikatorius.php"; 	//your file name  (the name of this file)
			$limit = 5; 									//how many items to show per page
			$page = $_GET['page'];

			if ($page) 
				$start = ($page - 1) * $limit; 			//first item to display on this page
			else
				$start = 0;								//if no page var is given, set start to 0



	$queryProducts = "SELECT * FROM products LIMIT $start, $limit";
	$products_result = mysql_query($queryProducts);

	echo "<table style=\"width:20%; text-align: center;\">
		  	<tr>
		  		<th>ID</th>
		  		<th>Nuotrauka</th>
		    	<th>Produktas</th>
		    	<th>Aprašymas</th>
		    	<th>Vienetai</th>
	  	  	</tr>";

	while($product = mysql_fetch_row($products_result)) {
		$sql = "SELECT name FROM quantities WHERE id='$product[2]'";
		$result = mysql_query($sql);
		$quantity = mysql_fetch_row($result);

       	echo "<tr>
       			<td>$product[0]</td>
       			<td>...</td>
       			<td>$product[3]</td>
       			<td>$product[4]</td>
       			<td>$quantity[0]</td>
       		  </tr>";
   	}

	echo "</table>";

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
	$pagination = "";

	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\"> <<< </a>";
		else
			$pagination.= "<span class=\"disabled\"> <<< </span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\"> >>> </a>";
		else
			$pagination.= "<span class=\"disabled\"> >>> </span>";
		$pagination.= "</div>\n";		
	}

	echo $pagination;

   	echo "<br /><br /><a href=\"index.php\">Atgal</a>";
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>