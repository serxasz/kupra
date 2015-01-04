<?php 
include('config.php');
$where = 'receptai';
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
if (loggedIn($where)) {
	$username = $_SESSION['username'];

	// meniukas
	echo '
	<ol class="breadcrumb">
	  <li><span class="glyphicon glyphicon-home"></span><a href="/"> Pradinis</a></li>
	  <li><a href="visi_receptai.php">Receptai</a></li>
	  <li class="active">Receptų sąrašas</li>
	</ol>';

	if ( 
			( !empty($_GET["page"]) )
				or 
			( empty($_GET) )
				or
			( !empty($_GET["limit"]) )
		)
		{
		echo "<h2>Receptų sąrašas</h2>";

		// Pagination 
			// Total number of rows in table
				$query = "SELECT COUNT(*) as num FROM recipes";
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
				$targetpage = "visi_receptai.php"; 	//your file name  (the name of this file)
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

				$page = $_GET['page'];

				if ($page) 
					$start = ($page - 1) * $limit; 			//first item to display on this page
				else
					$start = 0;								//if no page var is given, set start to 0

		$queryRecipes = "SELECT * FROM recipes LIMIT $start, $limit";
		
		$recipes_result = mysql_query($queryRecipes);

		echo "<table class=\"table table-bordered table-striped\" style=\"width: 50%\">
			  	<tr>
			  		<th style=\"width: 5%\">ID</th>
			    	<th style=\"width: 5%\">Autorius</th>
			    	<th style=\"width: 30%\">Pavadinimas</th>
			    	<th style=\"width: 5%\">Porcijos</th>
			    	<th style=\"width: 5%\">Gamybos trukmė</th>
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
    } else {
    	$viewID = $_GET["view"];

    	$queryRecipe = "SELECT * FROM recipes WHERE id='$viewID'";
    	$recipes_result = mysql_query($queryRecipe);
		$recipe = mysql_fetch_row($recipes_result);

		if ($recipe[1] == $username) {
			$edit = "<a href=\"redaguoti_recepta.php?edit=true&id=$recipe[0]\">  (Redaguoti receptą)</a>";
		} else {
			$edit = "";
		}
        echo '<table class="table table-bordered" align="center">';
    	echo "<tr align='center'><td colspan='2'><font size='6'>$recipe[2]</font>$edit</td></tr>";
        $file = glob("uploads/recipes/".$recipe[2]."/*.{jpg,jpeg,png,gif}",GLOB_BRACE);
        if (!empty($file)) {
        foreach ($file as $i) {
            echo '<tr align="center"><td colspan="2"><img src="'.$i.'" style="height:400px; width:400px;" alt="photo"></td></tr>';
        }
        }
    	echo "<tr align='center'><td width='20%'><b>Autorius:</b></td><td>$recipe[1]</td></tr>";
    	echo "<tr align='center'><td><b>Aprašymas:</b></td><td>$recipe[5]</td></tr>";
    	echo "<tr align='center'><td><b>Gamybos trukmė:</b></td><td>$recipe[4]</td></tr>";
    	echo "<tr align='center'><td><b>Porcijos:</b></td><td>$recipe[3]</td></tr>";
        echo '</table>';
    	echo "<h3>Produktai</h3>";

    	// get list of products

       	$queryProducts = "SELECT * FROM recipe_products WHERE recipe_id='$viewID'";
    	$products = mysql_query($queryProducts);
		echo "<table class=\"table table-bordered\" style=\"width:20%; text-align: center;\">
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

	   	echo "</table>";
		
	//REITINGAVIMAS
	$if_voted = mysql_query ("
	SELECT nameofuser, rating FROM rates WHERE nameofuser='$username'
	");
	
	if($row = mysql_fetch_assoc($if_voted)) {
		$votername = $row['nameofuser'];
		$ratinggiven = $row['rating'];
		//echo $votername;
		echo '<font color="red"><h1> jau balsavai! Davei '; echo $ratinggiven; echo ' !</h1></font><br>';
	} else {
	
	$find_data = mysql_query ("SELECT * FROM ratings WHERE recipe_name='$recipe[2]'");
	
	while ($row = mysql_fetch_assoc($find_data))
	{
		$id = $row['id'];
		$name_of_recipe = $row['recipe_name'];
		$current_hits = $row['hits'];
		
		echo "
			<form method='POST'>
				<select name='rating'>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
				</select>
				<input type='hidden' value='$recipe[2]' name='recipe_name'>
				<input type='submit' value='Ivertinti!' name='IVERTINIMAS'>
			</form>
		";
	}
	
	if ( isset( $_POST['IVERTINIMAS'] ) ) { 
	
	$post_recipe = $_POST['$recipe[2]'];
	$post_rating = $_POST['rating'];
	
	$new_hits = $current_hits + 1;
	
	$update_hits = mysql_query ("UPDATE ratings SET hits = '$new_hits' WHERE id='$id'");
	
	$sql69 = "INSERT INTO rates (nameofrecipe, nameofuser, rating, recipeid) VALUES ('$recipe[2]','$username','$post_rating', '$recipe[0]')";
	
	if (mysql_query($sql69)) {
	echo '<br>Vote priimtas!<br>';
	}
	$new_rating = mysql_query ("
	SELECT recipes.id, recipes.name, AVG(rates.rating) AS rating
	FROM recipes
	LEFT JOIN rates
	ON recipes.id = rates.recipeid
	GROUP BY recipes.id
	");
	
	while ($row = mysql_fetch_assoc($new_rating)){
		$newest_rating = $row['rating'];
	}
	$update_rating = mysql_query("UPDATE ratings SET rating ='$newest_rating' WHERE id='$id'");
     }   
		}
//////////
        $supply = "";
        $current = $recipe[0];
        $sql1 = "SELECT product_amount, product_id FROM recipe_products WHERE recipe_id = '$current'"; 
        $query1 = mysql_query($sql1) or die("Query Failed: " . mysql_error());
        $makeable = true;
        while ($product = mysql_fetch_array($query1)) {
        $sql2 = "SELECT product_id,quantity FROM fridge WHERE product_id = '".$product['product_id']."' AND fridge.username = '".$_SESSION['username']."' LIMIT 1"; 
            $query2 = mysql_query($sql2) or die("Query Failed: " . mysql_error());
            $answer = mysql_fetch_array($query2);
            if (mysql_num_rows($query2) == 1) {
                if ($answer['quantity'] >= $product['product_amount']) {                    
                } else {
                    $s = "SELECT name FROM products WHERE id = '".$product['product_id']."' LIMIT 1"; 
                    $q = mysql_query($s) or die("Query Failed: " . mysql_error());
                    $a = mysql_fetch_array($q);
                    if (mysql_num_rows($q) == 1) {
                    $kiek = $product['product_amount'] - $answer['quantity'];
                    $supply .= "<tr><td>".$a['name']."</td><td>".$kiek."</td></tr>";
                    }
                    $makeable = false;
                }
   } else {
                
                $s = "SELECT name FROM products WHERE id = '".$product['product_id']."' LIMIT 1"; 
                $q = mysql_query($s) or die("Query Failed: " . mysql_error());
                $a = mysql_fetch_array($q);
                if (mysql_num_rows($q) == 1) {
                $supply .= "<tr><td>".$a['name']."</td><td>".$product['product_amount']."</td></tr>";
                }
                $makeable = false;
            }
        }
        if ($makeable) {
            echo"<font color='green' size='4'>Šaldytuve yra pakankamai produktų šiam patiekalui pagaminti!</font>";
        } else {
            echo"<font color='red' size='4'>Nepakankamų produktų sąrašas:</font>";
            echo"<table class=\"table table-bordered\" style=\"width:20%; text-align: center;\">";
            echo"<tr align='center'><td align='center'><b>Produktas</b></td><td align='center'><b>Kiekis</b></td></tr>";
        }       
        $supply .= "</table>";
        echo $supply;
    }

} else {
	include('include_content/not_registered.php');
}

include('include_content/html_bottom.php'); 
?>