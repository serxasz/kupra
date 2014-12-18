<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[81]; 
if (loggedIn($where)) {

	$username = $_SESSION['username'];

	if (!empty($_GET)) {
		include('include_content/edit_rcp.php');
	}

	echo "<h3><a href=\"prideti_recepta.php\">Pridėti naują receptą</a></h3>";

	echo "<h2>Mano receptų sąrašas</h2>";
	
	// Pagination 
		// Total number of rows in table
			$query = "SELECT COUNT(*) as num FROM recipes WHERE username='$username'";
			$total_pages = mysql_fetch_array(mysql_query($query));
			$total_pages = $total_pages[num];
			echo "Viso įrašų: $total_pages";

		/* Setup vars for query. */
			$targetpage = "mano_receptai.php"; 	//your file name  (the name of this file)
			$limit = 5; 									//how many items to show per page
			$page = $_GET['page'];

			if ($page) 
				$start = ($page - 1) * $limit; 			//first item to display on this page
			else
				$start = 0;
			
	$queryRecipes = "SELECT * FROM recipes WHERE username='$username' LIMIT $start, $limit";
	
	$recipes_result = mysql_query($queryRecipes);

	echo "<table style=\"width:20%; text-align: center;\">
		  	<tr>
		  		<th>ID</th>
		    	<th>Autorius</th>
		    	<th>Pavadinimas</th>
		    	<th>Aprašymas</th>
		    	<th>Porcijos</th>
		    	<th>Gamybos trukmė</th>
		    	<th></th>
	  	  	</tr>";

	while ($recipe = mysql_fetch_row($recipes_result)) {
	    echo 	"<tr>
	       			<td>$recipe[0]</td>
	       			<td>$recipe[1]</td>
	       			<td>$recipe[2]</td>
	       			<td>$recipe[5]</td>
	       			<td>$recipe[3]</td>
	       			<td>$recipe[4]</td>
	       			<td><a href=\"mano_receptai.php?edit=true&id=$recipe[0]\">Redaguoti</a></td>
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
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>