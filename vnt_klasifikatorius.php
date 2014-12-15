<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[81]; 
if (loggedIn($where)) {
	$username = $_SESSION['username'];
	$administrator = isAdministrator($username);

	echo "<h2>Create</h2>";
	
	if (!empty($_POST)) {
		$quantity = $_POST['quantity'];

		// ar toks jau yra sukurtas?

		$sql = "INSERT INTO quantities (username, name) VALUES ('$username', '$quantity')";

		if (mysql_query($sql)) {
			echo "Sėkmingai papildyta klasifikatoriumi -> $name <br />";
		} else {
			echo "Papildyti klasifatoriaus nepavyko. Bandykite dar kartą.";
		}
	} else {
			echo '<form action="vnt_klasifikatorius.php" method="post">
					Pavadinimas: <input type="text" name="quantity"><input type="submit" value="Papildyti">
					</form>';
	}

	echo "<h2>Read | Update, Delete (if admin)</h2>";
	$sql = "SELECT * FROM quantities";
	$rs_result = mysql_query($sql); 
	while($row = mysql_fetch_row($rs_result)) {
       	if ($administrator) {
       		echo "Kurėjas: $row[1] - ";
       	}

       	echo "Klasifikatorius: $row[2]<br />";

       	if ($administrator) {
       		echo "Panaudota: ";
       	}
   	}
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>