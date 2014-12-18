<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[81]; 
if (loggedIn($where)) {

	$username = $_SESSION['username'];

	if ( (!empty($_GET["page"]) or (empty($_GET)) ) ) {
		echo "<h2>Visų receptų sąrašas</h2>";

		// Pagination 
			// Total number of rows in table
				$query = "SELECT COUNT(*) as num FROM recipes";
				$total_pages = mysql_fetch_array(mysql_query($query));
				$total_pages = $total_pages[num];
				echo "Viso įrašų: $total_pages";

			/* Setup vars for query. */
				$targetpage = "visi_receptai.php"; 	//your file name  (the name of this file)
				$limit = 10; 									//how many items to show per page
				$page = $_GET['page'];

				if ($page) 
					$start = ($page - 1) * $limit; 			//first item to display on this page
				else
					$start = 0;								//if no page var is given, set start to 0

		$queryRecipes = "SELECT * FROM recipes LIMIT $start, $limit";
		
		$recipes_result = mysql_query($queryRecipes);

		echo "<table style=\"width:20%; text-align: center;\">
			  	<tr>
			  		<th>ID</th>
			    	<th>Autorius</th>
			    	<th>Pavadinimas</th>
			    	<th>Porcijos</th>
			    	<th>Gamybos trukmė</th>
		  	  	</tr>";

		while ($recipe = mysql_fetch_row($recipes_result)) {
		    echo 	"<tr>
		       			<td>$recipe[0]</td>
		       			<td>$recipe[1]</td>
		       			<td><a href=\"visi_receptai.php?view=$recipe[0]\">$recipe[2]</a></td>
		       			<td>$recipe[3]</td>
		       			<td>$recipe[4]</td>
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
		include('include_content/pagination.php');
		
	   	echo "<br /><br /><a href=\"receptai.php\">Atgal</a>";
    } else {
    	$viewID = $_GET["view"];

    	$queryRecipe = "SELECT * FROM recipes WHERE id='$viewID'";
    	$recipes_result = mysql_query($queryRecipe);
		$recipe = mysql_fetch_row($recipes_result);

		if ($recipe[1] == $username) {
			$edit = "<a href=\"mano_receptai.php?edit=true&id=$recipe[0]\">  (Redaguoti receptą)</a>";
		} else {
			$edit = "";
		}

    	echo "<h2>Recepeto peržiūra</h2>";
    	echo "<h1>$recipe[2]</h1>$edit";
    	echo "<h4>Autorius: $recipe[1]</h4>";
    	echo "<h3>Aprašymas</h3>";
    	echo "$recipe[5]";
    	echo "<h4>Gamybos trukmė: $recipe[4]</h4>";
    	echo "<h4>Porcijos: $recipe[3]</h4>";
    	echo "<h3>Produktai</h3>";

    	// get list of products

       	$queryProducts = "SELECT * FROM recipe_products WHERE recipe_id='$viewID'";
    	$products = mysql_query($queryProducts);
		echo "<table style=\"width:20%; text-align: center;\">
			  	<tr>
			  		<th></th>
			  		<th>Produktas</th>
			    	<th>Vienetas</th>
			    	<th>Kiekis</th>
		  	  	</tr>";

		while ($product = mysql_fetch_row($products)) {
			$queryProductInfo = "SELECT * FROM products WHERE id='$product[2]'";
			$result_productInfo = mysql_query($queryProductInfo);
			$productInfo = mysql_fetch_row($result_productInfo);

			$queryQuantityInfo = "SELECT name FROM quantities WHERE id='$productInfo[2]'";
			$result_quantityInfo = mysql_query($queryQuantityInfo);
			$quantityInfo = mysql_fetch_row($result_quantityInfo);		
	        
	        $file = glob("uploads/products/*.{jpg,jpeg,png,gif}",GLOB_BRACE);
	        $image = "";
	        foreach ($file as $i) {
	            if ($i == "uploads/products/" . $productInfo[3] . ".jpg" or $i == "uploads/products/" . $productInfo[3] . ".jpeg" or $i == "uploads/products/" . $productInfo[3] . ".png" or $i == "uploads/products/" . $productInfo[3] . ".gif") {
	                        $image = '<img src="'.$i.'" alt="photo" height="75" width="75">';
	                    }
	                }

		    echo 	"<tr>
		    			<td>$image</td>
		       			<td>$productInfo[3]</td>
		       			<td>$quantityInfo[0]</td>
		       			<td>$product[3]</td>
		       		</tr>";
	   	}
    }

} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>