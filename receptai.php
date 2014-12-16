<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[81]; 
if (loggedIn($where)) {

	$username = $_SESSION['username'];

	echo "<h2>Naujas receptas</h2>";

	if (empty($_POST)) {
		echo '	<form action="receptai.php" method="post">
					<table style=width:20%; text-align: center;>
						<tr>
							<td>Pavadinimas:</td>
							<td><input type="text" name="name"><td>
						</tr>
						<tr>
						<tr>
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
	} else {
		$name = $_POST["name"];
		$description = $_POST["description"];

		print_r($_POST);
		$sql = "INSERT INTO recipes (username, name, description) VALUES ('$username','$name', '$description')";

		if (mysql_query($sql)) {
			echo "Sėkmingai papildyta.";
		}
	}
	
	echo "<h2>Receptų sąrašas</h2>";

	$queryRecipes = "SELECT * FROM recipes";
	
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
	       			<td>$recipe[2]</td>
	       			<td>$recipe[3]</td>
	       			<td>$recipe[4]</td>
	       		  </tr>";
   	}

	echo "</table>";

   	echo "<br /><br /><a href=\"index.php\">Atgal</a>";

} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>