<?php
include('config.php');
    
    $rcpID = $_GET['rcpid'];
    $q = $_GET['q'];

    $username = $_SESSION['username'];

    if (!empty($q)){
        echo "<h3>Rasta produktų užklausai - $q</h3>";
    }

    // Pagination 
    // Total number of rows in table
      $query = "SELECT COUNT(*) as num FROM products WHERE name LIKE '$q%'";
      $total_pages = mysql_fetch_array(mysql_query($query));
      $total_pages = $total_pages[num];
      echo "Viso įrašų: $total_pages";

    /* Setup vars for query. */
      $targetpage = "prideti_recepta.php?q=$q&rcpid=$rcpID";   //your file name  (the name of this file)
      $limit = 10;                  //how many items to show per page
      $page = $_GET['page'];

      if ($page) 
        $start = ($page - 1) * $limit;      //first item to display on this page
      else
        $start = 0;               //if no page var is given, set start to 0



      $queryProducts = "SELECT * FROM products WHERE name LIKE '$q%' LIMIT $start, $limit";
      $products_result = mysql_query($queryProducts);
      
      if(mysql_num_rows($products_result) > 0) { 
            echo "<table class=\"table table-bordered table-striped\" style=\"width:20%; text-align: center;\">
                <tr>
                  <th>Nuotrauka</th>
                  <th>Produktas</th>
                  <th>Aprašymas</th>
                  <th>Vienetas</th>
                  <th>Kiekis</th>
                  </tr>";
      } 
                
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
                <td>$image</td>
                <td>$product[3]</td>
                <td>$product[4]</td>
                <td>$quantity[0]</td>
                    <td>
                        <input type=\"text\" value=\"0\" size=\"5\" onchange=\"productAddition(this.value, $product[0], $rcpID)\">
                    </td>
                </tr>";
        }

      if(mysql_num_rows($products_result) > 0) { 
          echo "</table>";
        }

      /* Setup page vars for display. */
      if ($page == 0) $page = 1;          //if no page var is given, default to 1.
      $prev = $page - 1;              //previous page is page - 1
      $next = $page + 1;              //next page is page + 1
      $lastpage = ceil($total_pages/$limit);    //lastpage is = total pages / items per page, rounded up.
      $lpm1 = $lastpage - 1;            //last page minus 1
      /* 
        Now we apply our rules and draw the pagination object. 
        We're actually saving the code to a variable in case we want to draw it more than once.
      */

      include('include_content/pagination.php');
?>