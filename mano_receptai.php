<?php 
include('config.php');
$where = "mano_receptai";
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
	  <li class="active">Mano receptai</li>
	</ol>';

	echo "<h2>Mano receptai</h2>";
	
	// Pagination 
	$adjacents = 3;
		// Total number of rows in table
			$query = "SELECT COUNT(*) as num FROM recipes WHERE username='$username'";
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
			$targetpage = "mano_receptai.php"; 	//your file name  (the name of this file)
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
			
	$queryRecipes = "SELECT * FROM recipes WHERE username='$username' LIMIT $start, $limit";
	
	$recipes_result = mysql_query($queryRecipes);

		echo "<table class=\"table table-bordered table-striped\" style=\"width: 70%\">
		  	<tr>
			  	<th style=\"width: 5%\">ID</th>
			    <th style=\"width: 5%\">Autorius</th>
			    <th style=\"width: 30%\">Pavadinimas</th>
			    <th style=\"width: 5%\">Porcijos</th>
			    <th style=\"width: 5%\">Gamybos trukmė</th>
		    	<th style=\"width: 20%\"></th>
	  	  	</tr>";

	while ($recipe = mysql_fetch_row($recipes_result)) {
	    echo 	"<tr>
	       			<td>$recipe[0]</td>
	       			<td>$recipe[1]</td>
	       			<td><a href=\"visi_receptai.php?view=$recipe[0]\">$recipe[2]</a></td>
	       			<td>$recipe[3]</td>
	       			<td>$recipe[4]</td>
	       			<td><a href=\"redaguoti_recepta.php?edit=true&id=$recipe[0]\">Redaguoti</a></td>
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
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>