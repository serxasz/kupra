<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
$where=$phrase[81]; 
if (loggedIn($where)) {
	$username = $_SESSION['username'];
	$term = $_REQUEST['term'];
	$ieskoti = $term;

	echo '
	<ol class="breadcrumb">
	  <li><span class="glyphicon glyphicon-home"></span><a href="/"> Pradinis</a></li>
	  <li><a href="visi_receptai.php">Receptai</a></li>
	  <li class="active">Receptu paieska</li>
	</ol>';

//if ( isset( $_POST['term'] ) ) {
		echo "<h2>Rasti receptai: </h2>";

		$adjacents = 3;
			// Total number of rows in table
				$query = "
				SELECT COUNT(*) as num 
				FROM recipes
				WHERE name like '%$ieskoti%' or username like '%$ieskoti%'";
				$total_pages = mysql_fetch_array(mysql_query($query));
				$total_pages = $total_pages[num];

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
		echo "<form>Viso irasu: $total_pages. Puslapyje rodyti po: 
		<select name=\"limit\" onchange=\"this.form.submit()\">';
			<option $select10 value=\"10\">10</option>
			<option $select25 value=\"25\">25</option>
			<option $select50 value=\"50\">50</option>
		</select>
		<noscript><input type=\"submit\" value=\"Submit\"></noscript>
		</form>";
		echo '<br />';
				$targetpage = "globali_paieska.php"; 	
				$limit = 10; 									

				$customLimit = $_GET['limit'];
				if (isset($customLimit) & $customLimit != $limit) {
					$limit = $customLimit;
					$customLimit = "&limit=$customLimit";
				}			

				$page = $_GET['page'];

				if ($page) 
					$start = ($page - 1) * $limit; 			
				else
					$start = 0;							

		$queryRecipes = "select *
					from recipes
					where name
					like '%$ieskoti%'
					or username
					like '%$ieskoti%'
					LIMIT $start, $limit";
		
		$recipes_result = mysql_query($queryRecipes);

		echo "<table class=\"table table-bordered table-striped\" style=\"width: 80%\">
			  	<tr>
					<th>Nuotrauka</th>
					<th>Autorius</th>
					<th>Pavadinimas</th>
					<th>Porciju skaicius</th>
					<th>Pagaminimo trukme</th>
					<th>Reitingas</th>
					<th>Balsai</th>
				</tr>
				";

		while ($recipe = mysql_fetch_row($recipes_result)) {
        
        $image = '<img src="images/no-photo.jpg" style="height:200px; width:200px;" alt="photo">';
        $file = glob("uploads/recipes/".$recipe[2]."/*.{jpg,jpeg,png,gif}",GLOB_BRACE);
        if (!empty($file)) {
        foreach ($file as $i) {
            $image = '<img src="'.$i.'" style="height:200px; width:200px;" alt="photo">';
            break;
        }
        }
		    echo 	"<tr>
		       			<td><a href=\"visi_receptai.php?view=$recipe[0]\">$image</a></td>
		       			<td>$recipe[1]</td>
		       			<td><a href=\"visi_receptai.php?view=$recipe[0]\">$recipe[2]</a></td>
		       			<td>$recipe[3]</td>
		       			<td>$recipe[4]</td>
						<td>$recipe[7]</td>
						<td>$recipe[8]</td>
		       		  </tr>";
	   	}

		echo "</table>";

		if ($page == 0) $page = 1;				
		$prev = $page - 1;						
		$next = $page + 1;						
		$lastpage = ceil($total_pages/$limit);	
		$lpm1 = $lastpage - 1;				
		include('include_content/pagination.php');
	//}
	//else {
	//print "Uzsklausa su '$term'";
	//echo '<h2><font color ="red">nedave rezultatu.</font></h2>';
	//}
} else {
	echo '<h1><font color="red">Reikia prisijungti!</font><h1>';
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>