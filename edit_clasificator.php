<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$username = $_SESSION['username'];
$administrator = isAdministrator($username);
if (loggedIn($where) && isAdministrator($username)) {
	if (!empty($_POST)) {
		$id = $_POST["id"];
		$name = $_POST["name"];

   		$queryEdit = "UPDATE quantities SET name='$name' WHERE id='$id'";
   		mysql_query($queryEdit);

		echo "Pakeitimai išsaugoti.";
	}	

	if (!empty($_GET['edit'])) {
		$editingID = $_GET['edit'];

	} elseif (!empty($_GET['delete'])) {
		$id = $_GET['delete'];

   		$queryDelete = "DELETE FROM quantities WHERE id=$id";
   		mysql_query($queryDelete);
	}

	echo "<h2>Matavimo vienetai</h2>";

	$queryGetQuantities = "SELECT * FROM quantities";
	$quantities_result = mysql_query($queryGetQuantities); 
	
	echo "<table style=\"width:30%; text-align: center;\">
		  	<tr>
		    	<th>Kurėjas</th>
		    	<th>Klasifikatorius</th> 
		    	<th>Panaudota</th>
		    	<th></th>
	  	  	</tr>";

	while($quantity = mysql_fetch_row($quantities_result)) {
   		$panaudota_kartu = 0;

   		$queryUsed = "SELECT quantities_id FROM products WHERE quantities_id='$quantity[0]'";
   		$used_result = mysql_query($queryUsed);

   		while($used = mysql_fetch_row($used_result)) { 
   			$panaudota_kartu += 1;
   		}

   			if ($panaudota_kartu == 0) {
   				$controls = "<a href=\"edit_clasificator.php?edit=$quantity[0]\">Redaguoti</a>
   							 <a href=\"edit_clasificator.php?delete=$quantity[0]\">Ištrinti</a>";
   			} else {
   				$controls = "";
   			}

   			if (!($quantity[0] == $editingID)) {
	   			echo "<tr>
					 	<td>$quantity[1]</td>
				    	<td>$quantity[2]</td> 
				    	<td>$panaudota_kartu</td>
				    	<td>$controls</td>
					 </tr>";
			} else {
	   			echo "<form action=\"edit_clasificator.php\" method=\"post\">
	   				 	<tr>
						 	<td>$quantity[1]</td>
					    	<td><input type=\"text\" name=\"name\" value=\"$quantity[2]\"></td> 
					    	<td>$panaudota_kartu</td>
					    	<td><input type=\"hidden\" name=\"id\" value=\"$quantity[0]\"><input type=\"submit\" value=\"Išsaugoti\"></td>
					 	</tr>
					 </form>";
			}
   	}

   	echo "</table>";

   	echo "<br /><br /><a href=\"admin.php\">Atgal</a>";

} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>