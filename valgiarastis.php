<?php 
include('config.php');
$where = "valgiarastis"; 
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
if (loggedIn($where)) {

	$username = $_SESSION['username'];

    echo'
    <ol class="breadcrumb">
      <li><span class="glyphicon glyphicon-home"></span><a href="/"> Pradinis</a></li>
      <li class="active">Valgiaraštis</li>
    </ol>';

	
	echo "<h2>Valgiaraštis</h2>";
	 	
			
			
		
		$menus = "SELECT * FROM menus WHERE username='$username' ";
	
		$menus_result = mysql_query($menus);
		
		

	$menuid = 0;
	while ($menu = mysql_fetch_row($menus_result)) {
	
		echo "<table class=\"table table-bordered table-striped\" style=\"width: 70%\">
			<tr>
			  	<th colspan=\"3\"><center>Valgiaraštis $menu[0] '$menu[1]'</center></th>
			   

	  	  	</tr>

		  	<tr>
			    <th style=\"width: 50%\">Recepto Pavadinimas</th>
				<th style=\"width: 30%\">Produktai</th>
				<th style=\"width: 30%\">Gaminti</th>
				
				
			    

	  	  	</tr>";
	    echo 	'<tr>
	       			
					
					';
						
						
					
	
					$recept_result = mysql_query("SELECT * FROM menus_recipes WHERE menuid='$menu[0]' ");
					//echo "<table class=\"table table-bordered table-striped\" style=\"width: 20%\">";
					while ($rec = mysql_fetch_row($recept_result)) {
					
						$r_result =mysql_query('SELECT * FROM recipes WHERE id IN ('.$rec[0].')');
						while ($r = mysql_fetch_row($r_result)) {
							echo '
							<td><ceter>'.$r[2].'</center></td>';
						
						
				
				  	$queryProducts = "SELECT * FROM recipe_products WHERE recipe_id='$rec[0]'";
    	$products = mysql_query($queryProducts);
		echo "<td><table style=\"width:20%; text-align: center;\">
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

	  echo "</table></td>";
			
				
				
				
				
				
				
				
				
				
				
						echo '
								<td><input name="gaminti' . $menuid . '" type="submit" value="gaminti" /></td> </tr>';
								
						}
					}
					echo "<tr><td colspan=\"3\">";
						
					if (isset($_POST['go'.$menuid])) {
							$pun = $_POST['taskOption'.$menuid];
							
							$sql = "INSERT INTO menus_recipes (recipeid, menuid) VALUES ('$pun', '$menu[0]')";
							if (mysql_query($sql)) {
								echo "<center>Receptas priskirtas</center>";
							}
						
					}
					
					echo'<form method="post" action="valgiarastis.php">
					
					<center>
					<select name= "taskOption'.$menuid.'" >';
					$recipes = "SELECT * FROM recipes  ";
	
					$recipe_result = mysql_query($recipes);
					echo "<option value=\"0\">- prideti - </option>";
						
					while ($recipe = mysql_fetch_row($recipe_result)) {
						echo '<option value='.$recipe[0].' >'.$recipe[2].'</option>';
					}
					
				
					echo '
						</select>   
						
						<input name="go' . $menuid . '" type="submit" value="patvirtinti" />
						</form>
					</center>
					</td>
					
				
	       	
	       		  </tr>';
				  echo "</table>";
				  	$menuid = $menuid + 1;
   	}

	
		
}else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>