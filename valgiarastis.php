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
	 	
	$menus_result = mysql_query("SELECT * FROM menus WHERE username='$username' ");
	$menuid = 0;
	while ($menu = mysql_fetch_row($menus_result)) {	
			$recept_id = 0;
			$recept_result = mysql_query("SELECT * FROM menus_recipes WHERE menuid='$menu[0]' ");
			while ($rec = mysql_fetch_row($recept_result)) {
				$r_result = mysql_query('SELECT * FROM recipes WHERE id IN ('.$rec[1].')');
				while ($r = mysql_fetch_row($r_result)) {
						if (isset($_POST['trinti'.$menuid.''.$recept_id])) {
			
				
				mysql_query( 'DELETE FROM menus_recipes WHERE recipeid = '.$r[0].'');
				
			
		}
		
				}
				
				$recept_id = $recept_id + 1;
			}
			if (isset($_POST['go'.$menuid])) {
							$pun = $_POST['taskOption'.$menuid];
							
							$sql = "INSERT INTO menus_recipes (recipeid, menuid, date) VALUES ('$pun', '$menu[0]','$datedate')";
							if (mysql_query($sql)) {
								echo "<center>Receptas priskirtas</center>";
							}
						
					}
	$menuid = $menuid +1;
	}
	
	$menus_result = mysql_query("SELECT * FROM menus WHERE username='$username' ");
	$menuid = 0;
	while ($menu = mysql_fetch_row($menus_result)) {
	
		echo "<table class=\"table table-bordered table-striped\" style=\"width: 80%\">
			<tr>
				
			  	<th style=\"height: 120px\" colspan=\"2\"><center><BR><BR>Valgiaraštis $menu[0] '$menu[1]'</center></th>
			   

	  	  	</tr>

		  	<tr>
			    <th style=\"width: 50%\"><center>Recepto Pavadinimas</center></th>
				<th style=\"width: 50%\"><center>Produktai</center></th>
			
				
				
				
				
			    

	  	  	</tr>";
	    echo 	'<tr>
	       			
					
					';
						
						
					$recept_id = 0;
	
					$recept_result = mysql_query("SELECT * FROM menus_recipes WHERE menuid='$menu[0]' ");
					
					while ($rec = mysql_fetch_row($recept_result)) {
					
						$r_result = mysql_query('SELECT * FROM recipes WHERE id IN ('.$rec[1].')');
						while ($r = mysql_fetch_row($r_result)) {
							echo '
							<td><center>'.$r[2].'</center>';
							
							$image = '<img src="images/no-photo.jpg" style="height:200px; width:200px;" alt="photo">';
        $file = glob("uploads/recipes/".$r[2]."/*.{jpg,jpeg,png,gif}",GLOB_BRACE);
        if (!empty($file)) {
        foreach ($file as $i) {
            $image = '<img src="'.$i.'" style="height:200px; width:200px;" alt="photo">';
            break;
        }
        }
							
							echo '<br><a href=visi_receptai.php?view='.$r[0].'><center>'.$image.'</center><br></a></td>';
						
						
				
				  	$queryProducts = "SELECT * FROM recipe_products WHERE recipe_id='$rec[1]'";
    	$products = mysql_query($queryProducts);
		echo "<td><table class=\"table table-bordered table-striped\" BORDER='1' style=\"width:100%; text-align: center;\">
			  	<tr>
			  		<th>Produktas</th>
			    	<th>Vienetas</th>
			    	<th>Kiekis</th>
		  	  	</tr>";

	$galipagaminti = true;
	
		while ($product = mysql_fetch_row($products)) {
			
			$queryProductInfo = "SELECT * FROM products WHERE id='$product[2]'";
			$result_productInfo = mysql_query($queryProductInfo);
			$productInfo = mysql_fetch_row($result_productInfo);

			$queryQuantityInfo = "SELECT name FROM quantities WHERE id='$productInfo[2]'";
			$result_quantityInfo = mysql_query($queryQuantityInfo);
			$quantityInfo = mysql_fetch_row($result_quantityInfo);		
			if (isset($_POST['gaminti'.$menuid.''.$recept_id])) {
					$pun = $_POST['taskOption'.$menuid.''];
					
					
					if (mysql_query( 'update fridge set quantity=quantity-'.$product[3].' where product_id='.$productInfo[0].'')) {
						//echo "<center>Receptas Pagamintas</center>";
						mysql_query( 'DELETE FROM  fridge WHERE quantity < 0');
						
						
					}
				
			}
			
		
			
 
			
	        
	  
		    echo 	"<tr>
		       			<td>$productInfo[3]</td>
		       			<td>$quantityInfo[0]</td>
		       			";
						
						$sqla = "SELECT quantity FROM fridge WHERE product_id='$productInfo[0]' AND username='$username' ";
						$querya = mysql_query($sqla) or die("Query Failed: " . mysql_error());
						$cool = 0;
						$nocool = 0;
						$num= 0;
						while ($pro = mysql_fetch_row($querya)) {
							$cool = 1;
							
							$num = $pro[0];
						}
						$gali = true;
						//$galipagaminti 
						if ($cool == $nocool)
						{
							
							$galipagaminti = false;
							$gali = false;
						} else
						{
							
							if ($num < $product[3]) 
							{
								$gali = false;
								$galipagaminti = false;
							}
						}
						if ($gali == true)
					{

						
						
						echo '<td><font color="green">'.$num.'</font>/'.$product[3].'</td>';
					} else {
						echo '<td><font color="red">'.$num.'</font>/'.$product[3].'</td>';
						
					}
		       		echo "</tr>";
					
				
	   	}
						
	  echo "</table>";
						echo '<center><form method="post" action="valgiarastis.php">
							
								<input href="valgiarastis.php"  name="trinti' . $menuid . ''.$recept_id.'" type="submit" value="trinti" style=" width:100%;height:100%"  />
								
								</form></center>';
								
								echo '<br>';
								if ($galipagaminti == true)
								{
									
						echo '<center><form method="post" action="valgiarastis.php">
							
								<input href="valgiarastis.php"  name="gaminti' . $menuid . ''.$recept_id.'" type="submit" value="gaminti" style=" width:100%;height:100%"  />
								
								</form></center>';
								}
								else
									
									{
										echo '<center><form method="post" >
							
								<font color="red"><input color = "red" name="neuztenka produktų' . $menuid . ''.$recept_id.'" type="submit" value="neužtenka produktų pagaminti" style=" width:100%;height:100%;border: none"  />
								</font>
								</form></center>';
								}
								$recept_id = $recept_id + 1;	
							echo '</td> </tr>';		
						}
						
					}
					
					echo "<tr><td  colspan=\"2\"><Center>Naujas Receptas</center></td><tr><td colspan=\"2\">";
						
					
				
					echo'<form method="post" action="valgiarastis.php">
					
					<center>
					Recepto Pavadinimas
					<br>
					<select name= "taskOption'.$menuid.'" style=" width:30%">';
					$recipes = "SELECT * FROM recipes  ";
	
					$recipe_result = mysql_query($recipes);
					echo "<option value=\"0\">- prideti - </option>";
						
					while ($recipe = mysql_fetch_row($recipe_result)) {
						echo '<option value='.$recipe[0].' >'.$recipe[2].'</option>';
					}
					
				
					echo '
						</select>   <br><br>
						Pagaminimo Data
						<br>
						<input class="form-control" type="date" name="datedate"  style=" width:30%">
						<br>
						<input name="go' . $menuid . '" type="submit" value="patvirtinti" />
						</center>
						</form>
					
					
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