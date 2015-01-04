<?php 
include('config.php');

    $add = intval($_GET['add']);
    $productID = intval($_GET['id']);
    $rcpID = intval($_GET['rcpid']);

    if ($add > 0) {
		$sql = "INSERT INTO recipe_products (product_amount, product_id, recipe_id) VALUES ('$add', '$productID', '$rcpID')";

		if (mysql_query($sql)) {
			// get list of products
		    $viewID = $rcpID;
		   	$queryProducts = "SELECT * FROM recipe_products WHERE recipe_id='$viewID'";
			$products = mysql_query($queryProducts);

			if(mysql_num_rows($products) > 0) { 
				echo "<table style=\"width:20%; text-align: center;\">
					  	<tr>
					  		<th></th>
					  		<th>Produktas</th>
					    	<th>Vienetas</th>
					    	<th>Kiekis</th>
				  	  	</tr>";
			}

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
		            if ($i == "uploads/products/" . $productInfo[3] . ".jpg" 
		            	or 
		            	$i == "uploads/products/" . $productInfo[3] . ".jpeg" 
		            	or $i == "uploads/products/" . $productInfo[3] . ".png" 
		            	or $i == "uploads/products/" . $productInfo[3] . ".gif") {
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

			if(mysql_num_rows($products) > 0) { 
				echo "</table>";
			}
		} else {
			print_r(mysql_error());
			echo "!!! FAILLLLL !!!!";
		}
    }
?>