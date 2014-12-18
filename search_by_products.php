<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where="Ieškoti pagal produktus"; 
if (loggedIn($where)) {

    $TABLE_WIDTH = 600;
	
    $x = 0;
    $sql = "SELECT DISTINCT recipe_id FROM fridge,recipe_products WHERE fridge.product_id = recipe_products.product_id  AND fridge.username = '".$_SESSION['username']."'"; 
    $query = mysql_query($sql) or die("Query Failed: " . mysql_error());
    while ($recipe = mysql_fetch_array($query)) {
        $current = $recipe['recipe_id'];
        $sql1 = "SELECT product_amount, product_id FROM recipe_products WHERE recipe_id = '$current'"; 
        $query1 = mysql_query($sql1) or die("Query Failed: " . mysql_error());
        $makeable = true;
        while ($product = mysql_fetch_array($query1)) {
        $sql2 = "SELECT product_id,quantity FROM fridge WHERE product_id = '".$product['product_id']."' AND fridge.username = '".$_SESSION['username']."' LIMIT 1"; 
            $query2 = mysql_query($sql2) or die("Query Failed: " . mysql_error());
            $answer = mysql_fetch_array($query2);
            if (mysql_num_rows($query2) == 1) {
                if ($answer['quantity'] >= $product['product_amount']) {                    
                } else {
                    $makeable = false;
                }
			} else {
                $makeable = false;
            }
        }
        if ($makeable) {
            $recipes[$x] = $recipe['recipe_id'];
            $x++;
        }
    }  
    
    echo'<table width="'.$TABLE_WIDTH.'" border="1" align="center" cellpadding="5" cellspacing="1">';
    echo'<tr><td>ID</td><td>Autorius</td><td>Pavadinimas</td><td>Porcijos</td><td>Pagaminimo trukmė</td></tr>';
    
    if (!empty($recipes)) {
        foreach ($recipes as $i) {
            $sql = "SELECT id,username,name,portions,duration FROM recipes WHERE id = '".$i."' LIMIT 1"; 
            $query = mysql_query($sql) or die("Query Failed: " . mysql_error());
            $recipe = mysql_fetch_array($query);
            if (mysql_num_rows($query) == 1) {
                echo"<tr><td>".$recipe['id']."</td><td>".$recipe['username']."</td><td>".$recipe['name']."</td><td>".$recipe['portions']."</td><td>".$recipe['duration']."</td></tr>";
            }
        }
    } else {
        echo'<tr><td colspan="5" align="center">Nėra receptų, kuriuos galite pagaminti!</td></tr>';
    }
    echo'</table>';
    
}else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>