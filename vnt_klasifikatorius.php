<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[81]; 
if (loggedIn($where)) {
	$username = $_SESSION['username'];

	echo "<h3>To Do</h3>";
		echo "<br />";
	echo "Turėtų būti pasirinkimai: <br />";
		echo "po kiek elementų rodyti viename lange. (atskiras)<br />";
		echo "rikiuot pagal abecėlę <br />";
		echo "naujausias virsuje? <br />";
		echo "<br />";
	echo "URL turėtų būti draugiškesnis akiai";
		echo "<br />";
	echo "Multilanguage";

	echo "<h2>Naujas vienetas</h2>";
	
	if (!empty($_POST)) {
		$newQuantityName = $_POST['quantity'];

		// Validation
			// Wrong format
			$minQuantityLength = 2;
			$maxQuantityLength = 20;

			if ( (strlen($newQuantityName) < $minQuantityLength) or (strlen($newQuantityName) > $maxQuantityLength) ) {
				$wrongFormat = true;
			} else {
				$wrongFormat = false;
			}

			// Duplicate
			$duplicate = false;

			$queryQuantities = "SELECT name FROM quantities";

			$quantities_result = mysql_query($queryQuantities);

			while($quantity = mysql_fetch_row($quantities_result)) {
				if ($quantity[0] == $newQuantityName) {
					$duplicate = true;
					break;
				}
			}

			if ($duplicate) {
				echo "Vienetas su vardu \"$newQuantityName\" jau egzistuoja.";
			} else if ($wrongFormat) {
				echo "Leidžiamas vieneto pavadinimo dydis yra nuo $minQuantityLength simbolių iki $maxQuantityLength";
			} else {
				$sql = "INSERT INTO quantities (username, name) VALUES ('$username', '$newQuantityName')";

				if (mysql_query($sql)) {
					echo "Sėkmingai papildyta \"$newQuantityName\" vienetu.";
				}
			}

			echo 	"<br />
				  	 <br />
				  	 <a href=\"vnt_klasifikatorius.php\">Įvesti kitą</a>";
	} else {
		echo 	'<form action="vnt_klasifikatorius.php" method="post">
					Pavadinimas: <input type="text" name="quantity">
					<input type="submit" value="Papildyti">
				 </form>';
	}

	echo "<h2>Matavimo vienetai</h2>";
	// Pagination 
		// Total number of rows in table
			$query = "SELECT COUNT(*) as num FROM quantities";
			$total_pages = mysql_fetch_array(mysql_query($query));
			$total_pages = $total_pages[num];
			echo "Viso įrašų: $total_pages<br /><br />";

		/* Setup vars for query. */
			$targetpage = "vnt_klasifikatorius.php"; 	//your file name  (the name of this file)
			$limit = 5; 								//how many items to show per page

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

	$queryQuantities = "SELECT * FROM quantities LIMIT $start, $limit";
	$quantities_result = mysql_query($queryQuantities);

	echo "<table class=\"table table-bordered table-striped\" style=\"width:20%; text-align: center;\">
			<thead>
			  	<tr>
			    	<th class=\"text-center\">Vienetas</th> 
		  	  	</tr>
	  	  	</thead>
	  	  	<tbody>";

	while($quantity = mysql_fetch_row($quantities_result)) {
       	echo "<tr>
       			<td>$quantity[2]</td>
       		  </tr>";
   	}
	echo "</tbody></table>";

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

   	echo "<br /><br /><a href=\"index.php\">Atgal</a>";

} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>