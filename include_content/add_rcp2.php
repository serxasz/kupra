<?php
	$username = $_SESSION['username'];

	echo "<h2>Naujo recepto kūrimas (Etapas 2 iš 2) (Work in progres...)</h2>";

		echo "<h3>Produktų sąrašas</h3>";

	// Pagination 
		// Total number of rows in table
			$query = "SELECT COUNT(*) as num FROM products";
			$total_pages = mysql_fetch_array(mysql_query($query));
			$total_pages = $total_pages[num];
			echo "Viso įrašų: $total_pages";

		/* Setup vars for query. */
			$targetpage = "produktu_klasifikatorius.php"; 	//your file name  (the name of this file)
			$limit = 10; 									//how many items to show per page
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
		    	<th>Produktas</th>
		    	<th>Aprašymas</th>
		    	<th>Vienetai</th>
                <th>Nuotrauka</th>
                <th>Pridėti</th>
	  	  	</tr>";
            
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
                <td><input type=\"text\" name=\"productsToAdd[]\" value=\"0\" size=\"5\"></td>
       		  </tr>";
   	}
   	echo '<tr>
       			<td></td>
       			<td></td>
       			<td></td>
       			<td></td>
                <td></td>
                <td><br /><input type="submit" value="Saugoti."></td>
       		  </tr>';
	echo "</table></form>";

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

   	?>