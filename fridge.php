<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where="Šaldytuvas"; 
if (loggedIn($where)) {
    
    $TABLE_WIDTH = 800;
    $NUM_ROWS = 4;
    $count = 0;
    $shelf = 0;
    $sOutput = "";
    
    if (strtolower($_GET['action']) == 'delete2') {
        if ((is_numeric($_POST["id"])) && (0<=$_POST["id"])) {
            if ((is_numeric($_POST["quantity"])) && (0<$_POST["quantity"]) && (10000>=$_POST["quantity"])) {
            $sql1 = "SELECT quantity FROM fridge WHERE id = '".mysql_real_escape_string($_POST["id"])."' and username = '".$_SESSION['username']."' LIMIT 1"; 
            $query1 = mysql_query($sql1) or die("Query Failed2: " . mysql_error());
            if (mysql_num_rows($query1) == 1) {
                $row = mysql_fetch_array($query1);
                if ($_POST["quantity"] >= $row['quantity']) {
                $sql = "DELETE from fridge WHERE id = '".$_POST["id"]."' and username = '".$_SESSION['username']."'";
                $query = mysql_query($sql) or die("Query Failed2: " . mysql_error());
                $_SESSION['error'] = "Ištrinta sėkmingai!";
                unset($_GET['action']);                
                } else {
                    $result = mysql_query("UPDATE fridge SET quantity='".($row['quantity']-$_POST["quantity"])."' 
										WHERE username='" . $_SESSION['username'] . "' AND id='".mysql_real_escape_string($_POST["id"])."'") or die(mysql_error());
                    $_SESSION['error'] = "Produkto kiekis sumažintas sėkmingai!"; 
                    unset($_GET['action']);
                }
            }
            unset($_GET['action']);
        }
        }
    }
    if (strtolower($_GET['action']) == 'delete') {
        $sOutput .='<form name="change" method="post" action="fridge.php?action=delete2">
			<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr> 
				<td colspan="2" align="center"><strong>Atimti:</strong></td>
            </tr>
            <tr>
            <td align="center"><strong>Kiekis:</strong></td>
            <td align="center"><input type="text" size="5" name="quantity" value="">
            <input type="hidden" name="id" value="'.$_GET['delete'].'"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value="Ištrinti"></td>
			</tr></table></form>';
    }
    if (strtolower($_GET['action']) == 'confirm') {
        if ((is_numeric($_POST["quantity"])) && (0<$_POST["quantity"]) && (10000>=$_POST["quantity"])) {
            if (!empty($_POST["quantity"]) and !empty($_POST["product"]) and !empty($_POST["shelf"])) {
                $sql1 = "SELECT quantity FROM fridge WHERE product_id = '".mysql_real_escape_string($_POST["product"])."' and username = '".$_SESSION['username']."' LIMIT 1"; 
                $query1 = mysql_query($sql1) or die("Query Failed2: " . mysql_error());
                if (mysql_num_rows($query1) == 1) {
                    $row = mysql_fetch_array($query1);
                    $result = mysql_query("UPDATE fridge SET quantity='".($row['quantity']+$_POST["quantity"])."' 
										WHERE username='" . $_SESSION['username'] . "' AND product_id='".mysql_real_escape_string($_POST["product"])."'") or die(mysql_error());
                    $_SESSION['error'] = "Produkto kiekis papildytas sėkmingai!"; 
                    unset($_GET['action']);
            } else {
                $sql = "INSERT INTO fridge (username, product_id, quantity, shelf) VALUES ('".$_SESSION['username']."', '".$_POST["product"]."','".$_POST["quantity"]."','".$_POST["shelf"]."')";
                $query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
                $_SESSION['error'] = "Produktas pridėtas sėkmingai!"; 
                unset($_GET['action']);
            }
            } else { 
                $_SESSION['error'] = "Kažkuris laukas paliktas tuščias!";
                $_GET['action'] = "add";
            }
        } else { 
            $_SESSION['error'] = "Netinkamas kiekis!";
            $_GET['action'] = "add";
        }
    }
    if (strtolower($_GET['action']) == 'add') {
         if (!empty($_SESSION['error'])) { 
		$sError = '<span id="error">' . $_SESSION['error'] . '</span><br>';
		$sOutput .= '
		<table width="340"  border="0" align="center" cellpadding="3" cellspacing="5" bgcolor="#FFCCCC">
			<tr>
				<td><div align="center"><strong><font color="#FF0000">' . $sError . '</font></strong></div></td>
			</tr>
		</table>';
		unset($_SESSION['error']);
	} 
        $sOutput .= '<form name="change" method="post" action="fridge.php?action=confirm">
			<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr> 
				<td colspan="2" align="center"><strong>Pridėti:</strong></td>
                <tr>
                <td align="center"><strong>Produktas:</strong></td>
				<td align="center">
                <select name="product">
                <option value="" selected="selected">-------</option>';
        $sql = "SELECT id,quantities_id,name,description,picture_path FROM products ORDER BY name ASC";
        $query = mysql_query($sql) or die("Query Failed: " . mysql_error());
        while ($row = mysql_fetch_array($query)) {
            $sql2 = "SELECT name FROM quantities WHERE id = ".$row['quantities_id']." LIMIT 1"; 
            $query2 = mysql_query($sql2) or die("Query Failed2: " . mysql_error());
            $quantity = mysql_fetch_array($query2);
            $sOutput .='<option value="'.$row['id'].'">'.$row['name'].' ('.$quantity['name'].')</option>';
        }
		$sOutput .='</select>
                </td>
			</tr><tr>
            <td align="center"><strong>Lentyna:</strong></td>
				<td align="center">
                <select name="shelf">
                <option value="" selected="selected">-------</option>';
        for ($i = 1; $i < 100; $i++) {
            $sOutput .='<option value="'.$i.'">Lentyna '.$i.'</option>';
        }    
        $sOutput .='</select>
                </td>
			</tr>
            <tr>
            <td align="center"><strong>Kiekis:</strong></td>
            <td align="center"><input type="text" size="5" name="quantity" value=""></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value="Pridėti"></td>
			</tr></table></form>';
    } 
    if (empty($_GET['action'])) {
     if (!empty($_SESSION['error'])) { 
		$sError = '<span id="error">' . $_SESSION['error'] . '</span><br>';
		$sOutput .= '
		<table width="340"  border="0" align="center" cellpadding="3" cellspacing="5" bgcolor="#FFCCCC">
			<tr>
				<td><div align="center"><strong><font color="#FF0000">' . $sError . '</font></strong></div></td>
			</tr>
		</table>';
		unset($_SESSION['error']);
	} 
    $sOutput .= '<table width="'.$TABLE_WIDTH.'" border="1" align="center" cellpadding="5" cellspacing="1">';
    $sOutput .= "<tr><td align='center' colspan='4'><a href='fridge.php?action=add'><font color='green'>Pridėti</font></a></td></tr><tr>";    
	$sql = "SELECT id,username,product_id,quantity,shelf FROM fridge WHERE username = '".$_SESSION['username']."' ORDER BY shelf ASC";
    $query = mysql_query($sql) or die("Query Failed: " . mysql_error());
	while ($row = mysql_fetch_array($query)) {
        if ($shelf == 0) { 
        $shelf = 1;
        $sOutput .= '</tr><tr><td colspan="'.$NUM_ROWS.'" align="center">Lentyna '.$shelf.'</td></tr><tr>';
        } else if ($shelf < $row['shelf']) { 
            $shelf = $row['shelf'];
            $count = 0;
            $sOutput .= '</tr><tr><td colspan="'.$NUM_ROWS.'" align="center">Lentyna '.$shelf.'</td></tr><tr>';
        }
        $count++;
        $sql1 = "SELECT quantities_id,name,description,picture_path FROM products WHERE id = ".$row['product_id']." LIMIT 1"; 
        $query1 = mysql_query($sql1) or die("Query Failed2: " . mysql_error());
        $product = mysql_fetch_array($query1);
        $sql2 = "SELECT name FROM quantities WHERE id = ".$product['quantities_id']." LIMIT 1"; 
        $query2 = mysql_query($sql2) or die("Query Failed2: " . mysql_error());
        $quantity = mysql_fetch_array($query2);
        if (empty($product['picture_path'])) { 
            $path = "images/no-photo.jpg";
        } else {
            $path = $product['picture_path'];
        }
		$sOutput .= "<td width='".$TABLE_WIDTH/$NUM_ROWS."' title='Aprašymas: ".$product['description']."' align='left'>
        <img src='".$path."' align='left' alt='".$product['name']."' height='".($TABLE_WIDTH/8)."' width='".($TABLE_WIDTH/8)."'> 
         <font size='2'>
         <p>&nbsp;".$product['name']."</p>
         <p>&nbsp;".$row['quantity']." ".$quantity['name']."</p></font>
         <p>&nbsp;<a href='fridge.php?action=delete&delete=".$row['id']."'><font color='red'>Trinti</font></a></p>
         </td>";
        if ($count==4) { $sOutput .= "</tr><tr>"; $count=0; }
	}
    $sOutput .= '</tr></table>';
    }
    echo $sOutput;
}else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>