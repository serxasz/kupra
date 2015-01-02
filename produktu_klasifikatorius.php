<?php 
include('config.php');
$where = "produktai";
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
if (loggedIn($where)) {
	$username = $_SESSION['username'];

	// meniukas
	echo '
	<ol class="breadcrumb">
	  <li><a href="/">Pradinis</a></li>
	  <li><a href="produktu_klasifikatorius.php">Produktai</a></li>
	  <li class="active">Produktų sąrašas</li>
	</ol>';
	
	echo "<h2>Produktų sąrašas</h2>";

	// Pagination 
		// Total number of rows in table
			$query = "SELECT COUNT(*) as num FROM products";
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
			$targetpage = "produktu_klasifikatorius.php"; 	//your file name  (the name of this file)
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



	$queryProducts = "SELECT * FROM products LIMIT $start, $limit";
	$products_result = mysql_query($queryProducts);

	echo "<table class=\"table table-bordered table-striped\">
		<thead>
		  	<tr>
		  		<th style=\"width: 5%\">ID</th>
		    	<th style=\"width: 15%\">Produktas</th>
		    	<th style=\"width: 50%\">Aprašymas</th>
		    	<th style=\"width: 15%\">Vienetai</th>
                <th style=\"width: 15%\">Nuotrauka</th>
	  	  	</tr>
        </thead>
        <tbody>";
    $file = glob("uploads/products/*.{jpg,jpeg,png,gif}",GLOB_BRACE);

	while($product = mysql_fetch_row($products_result)) {
		$sql = "SELECT name FROM quantities WHERE id='$product[2]'";
		$result = mysql_query($sql);
		$quantity = mysql_fetch_row($result);
        
        $image = "";
        foreach ($file as $i) {
            if ($i == "uploads/products/" . $product[3] . ".jpg" or $i == "uploads/products/" . $product[3] . ".jpeg" or $i == "uploads/products/" . $product[3] . ".png" or $i == "uploads/products/" . $product[3] . ".gif") {
                        $image = '<img src="'.$i.'" alt="photo" height="75" width="75">';
                    }
                }

       	echo "<tr>
       			<td>$product[0]</td>
       			<td>$product[3]</td>
       			<td>$product[4]</td>
       			<td>$quantity[0]</td>
                <td>$image</td>
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
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>