<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$username = $_SESSION['username'];
$administrator = isAdministrator($username);
if (loggedIn($where) && isAdministrator($username)) {
	if (!empty($_POST)) {
		
	};

	echo "<h2>Matavimo vienetai</h2>";

	$queryGetQuantities = "SELECT * FROM quantities";
	$quantities_result = mysql_query($queryGetQuantities); 
	
	echo "<table style=\"width:20%; text-align: center;\">
		  	<tr>
		    	<th>Kurėjas</th>
		    	<th>Klasifikatorius</th> 
		    	<th>Panaudota</th>
		    	<th>Veiksmas</th>
	  	  	</tr>";

	while($quantity = mysql_fetch_row($quantities_result)) {
   		$panaudota_kartu = 0;

   		$queryUsed = "SELECT quantities_id FROM products";
   		$used_result = mysql_query($queryUsed);

   		while($used = mysql_fetch_row($used_result)) { 
   			if ($used[0] == $quantity[0]) {
   				$panaudota_kartu += 1;
   			}

   			echo "<tr>
			    	<td>$quantity[1]</td>
			    	<td>$quantity[2]</td> 
			    	<td>$panaudota_kartu</td>
			    	<td></td>
			 	  </tr>";
       	}
   	}

   	echo "</table>";

   	echo "<br /><br /><a href=\"admin.php\">Atgal</a>";

} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>