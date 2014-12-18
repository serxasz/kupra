<?php 
include('config.php');
include('include_content/html_top.php');
//include('include_content/language.php');
$where=$phrase[81]; 
if (loggedIn($where)) {
	$term = $_POST['term'];
	$query = "
			SELECT COUNT(*)
			as num
			FROM recipes
			where name like '%$term%' or username like '%$term%'
			";
			
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
			
	if ($total_pages > 0){
		echo "<h1>Rasti receptai</h1>";
		echo "Viso irasu: $total_pages";
		$targetpage = "globali_paieska.php";
		$limit = 5; 							
		$page = $_GET['page'];
		if ($page) 
			$start = ($page - 1) * $limit; 			
		else
			$start = 0;							

	$queryRecipes = "select *
					from recipes
					where name
					like '%$term%'
					or username
					like '%$term%'
					LIMIT $start, $limit";
					
	$recipes_result = mysql_query($queryRecipes);

	echo "<table style=\"width:20%; text-align: center;\">
		  	<tr>
		  		<th>Autorius</th>
		    	<th>Pavadinimas</th>
		    	<th>Porciju skaicius</th>
		    	<th>Pagaminimo trukme</th>
				<th>Aprasymas</th>
	  	  	</tr>";

	while($recipe = mysql_fetch_row($recipes_result)) {
		$sql = "SELECT name FROM quantities WHERE id='$recipe[2]'";
		$result = mysql_query($sql);
		$quantity = mysql_fetch_row($result);

       	echo "<tr>
       			<td>$recipe[1]</td>
       			<td>$recipe[2]</td>
       			<td>$recipe[3]</td>
       			<td>$recipe[4]</td>
				<td>$recipe[5]</td>
       		  </tr>";
   	}

	echo "</table>";

	if ($page == 0) $page = 1;					
	$prev = $page - 1;							
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);		
	$lpm1 = $lastpage - 1;						

	$pagination = "";

	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";

		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\"> <<< </a>";
		else
			$pagination.= "<span class=\"disabled\"> <<< </span>";	
		
		if ($lastpage < 7 + ($adjacents * 2))
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))
		{
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\"> >>> </a>";
		else
			$pagination.= "<span class=\"disabled\"> >>> </span>";
		$pagination.= "</div>\n";		
	}

	echo $pagination;
	}
	else {
	print "Uzsklausa su '$term'";
	echo '<h2><font color ="red">nedave rezultatu.</font></h2>';
	}

   	echo "<br /><br /><a href=\"mano_receptai.php\">Mano receptai</a>";
	echo "<br /><br /><a href=\"index.php\">I pagrindini meniu</a>";
} else {
	echo '<h1><font color="red">Reikia prisijungti!</font><h1>';
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>